<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BusinessPlanController extends Controller
{
    public function index()
    {
        return view('wizard.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'company_name'              => 'required|string|max:255',
            'logo'                      => 'nullable|image|max:4096',
            'business_photos.*'         => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['logo', 'business_photos']);

        // Handle logo upload — saved to public/images/logos
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!is_dir(public_path('images/logos'))) {
                mkdir(public_path('images/logos'), 0775, true);
            }
            $file->move(public_path('images/logos'), $filename);
            $data['logo_path'] = 'images/logos/' . $filename;
        }

        // Handle business photos — saved to public/images/photos
        if ($request->hasFile('business_photos')) {
            $photoPaths = [];
            if (!is_dir(public_path('images/photos'))) {
                mkdir(public_path('images/photos'), 0775, true);
            }
            foreach ($request->file('business_photos') as $photo) {
                $filename = 'photo_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/photos'), $filename);
                $photoPaths[] = 'images/photos/' . $filename;
            }
            $data['photo_paths'] = $photoPaths;
        }

        // Store in session
        session(['business_plan' => $data]);

        return redirect()->route('preview');
    }

    public function preview()
    {
        $data = session('business_plan');
        if (!$data) {
            return redirect()->route('home')->with('error', 'Please fill in the business plan form first.');
        }

        // Decode JSON fields
        $data = $this->decodeJsonFields($data);

        return view('plan.preview', compact('data'));
    }

    public function exportPdf(Request $request)
    {
        $data = session('business_plan');
        if (!$data) {
            return redirect()->route('home');
        }

        $data = $this->decodeJsonFields($data);

        // Convert logo to base64 for PDF embedding
        if (!empty($data['logo_path'])) {
            $logoFull = public_path($data['logo_path']);
            if (file_exists($logoFull)) {
                $type = pathinfo($logoFull, PATHINFO_EXTENSION);
                $data['logo_base64'] = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoFull));
            }
        }

        // Convert photos to base64
        if (!empty($data['photo_paths'])) {
            $data['photos_base64'] = [];
            foreach ($data['photo_paths'] as $path) {
                $full = public_path($path);
                if (file_exists($full)) {
                    $type = pathinfo($full, PATHINFO_EXTENSION);
                    $data['photos_base64'][] = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($full));
                }
            }
        }

        $pdf = Pdf::loadView('plan.pdf', compact('data'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'   => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'dpi'           => 150,
            ]);

        $filename = strtolower(str_replace(' ', '-', $data['company_name'])) . '-business-plan.pdf';

        return $pdf->download($filename);
    }

    private function decodeJsonFields(array $data): array
    {
        $jsonFields = [
            'directors', 'management_staff', 'technical_staff', 'key_cvs',
            'competitors', 'supply_sources',
            'raw_materials', 'machineries', 'liabilities',
            'team_members', 'milestones',
            'project_costs', 'manpower',
            'monthly_expenses', 'revenue_projections', 'cashflow_data',
            'five_year_projections',
        ];
        foreach ($jsonFields as $field) {
            if (!empty($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true) ?? [];
            }
        }
        return $data;
    }
}
