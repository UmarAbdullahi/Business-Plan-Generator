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
            'company_name'       => 'required|string|max:255',
            'tagline'            => 'nullable|string|max:255',
            'industry'           => 'required|string|max:255',
            'founded_year'       => 'nullable|integer|min:1900|max:2099',
            'business_model'     => 'required|string',
            'problem_statement'  => 'required|string',
            'solution'           => 'required|string',
            'value_proposition'  => 'required|string',
            'target_market'      => 'required|string',
            'logo'               => 'nullable|image|max:2048',
            'business_photos.*'  => 'nullable|image|max:4096',
            'primary_color'      => 'nullable|string|max:7',
            'secondary_color'    => 'nullable|string|max:7',
            // Market
            'tam'                => 'required|numeric',
            'sam'                => 'required|numeric',
            'som'                => 'required|numeric',
            // Competitors JSON
            'competitors'        => 'nullable|string',
            // Team JSON
            'team_members'       => 'nullable|string',
            // Milestones JSON
            'milestones'         => 'nullable|string',
            // Financials
            'startup_costs'      => 'required|numeric',
            'monthly_expenses'   => 'required|string', // JSON
            'revenue_projections'=> 'required|string', // JSON
            'cashflow_data'      => 'required|string', // JSON
            'price_per_unit'     => 'required|numeric',
            'variable_cost_per_unit' => 'required|numeric',
            'fixed_costs_monthly'=> 'required|numeric',
        ]);

        $data = $request->except(['logo', 'business_photos']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $data['logo_path'] = $path;
        }

        // Handle business photos
        if ($request->hasFile('business_photos')) {
            $photoPaths = [];
            foreach ($request->file('business_photos') as $photo) {
                $photoPaths[] = $photo->store('uploads/photos', 'public');
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
            $logoFull = storage_path('app/public/' . $data['logo_path']);
            if (file_exists($logoFull)) {
                $type = pathinfo($logoFull, PATHINFO_EXTENSION);
                $data['logo_base64'] = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoFull));
            }
        }

        // Convert photos to base64
        if (!empty($data['photo_paths'])) {
            $data['photos_base64'] = [];
            foreach ($data['photo_paths'] as $path) {
                $full = storage_path('app/public/' . $path);
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
        $jsonFields = ['monthly_expenses', 'revenue_projections', 'cashflow_data', 'competitors', 'team_members', 'milestones'];
        foreach ($jsonFields as $field) {
            if (!empty($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true) ?? [];
            }
        }
        return $data;
    }
}
