<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['company_name'] }} — Business Plan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --primary: {{ $data['primary_color'] ?? '#6366f1' }}; --secondary: {{ $data['secondary_color'] ?? '#8b5cf6' }}; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; margin: 0; }
        .page { width: 210mm; min-height: 297mm; background: white; margin: 20px auto; box-shadow: 0 4px 30px rgba(0,0,0,0.12); position: relative; overflow: hidden; page-break-after: always; }
        .cover-page { background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%); display: flex; flex-direction: column; justify-content: center; padding: 60px; color: white; position: relative; }
        .section-page { padding: 45px 50px; }
        .page-header { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; padding-bottom: 14px; border-bottom: 2px solid; border-image: linear-gradient(90deg, var(--primary), var(--secondary)) 1; }
        .section-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 16px; background: linear-gradient(135deg, var(--primary), var(--secondary)); }
        .page-header h2 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; }
        .card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 16px; }
        .card-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin-bottom: 6px; }
        .card-value { font-size: 22px; font-weight: 800; color: #0f172a; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .highlight { border-left: 4px solid var(--primary); padding: 12px 16px; background: #f8fafc; border-radius: 0 10px 10px 0; margin-bottom: 12px; }
        .highlight h3 { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 5px; }
        .highlight p { font-size: 13px; color: #334155; margin: 0; line-height: 1.6; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; }
        .badge-low { background: #dcfce7; color: #166534; }
        .badge-medium { background: #fef9c3; color: #854d0e; }
        .badge-high { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th { background: #f1f5f9; padding: 8px 12px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
        td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .timeline { position: relative; padding-left: 28px; }
        .timeline::before { content: ''; position: absolute; left: 7px; top: 8px; bottom: 8px; width: 2px; background: linear-gradient(180deg, var(--primary), var(--secondary)); }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-dot { position: absolute; left: -24px; top: 3px; width: 12px; height: 12px; border-radius: 50%; background: var(--primary); border: 2px solid white; box-shadow: 0 0 0 2px var(--primary); }
        .timeline-date { font-size: 10px; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 2px; }
        .timeline-title { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
        .timeline-desc { font-size: 11px; color: #64748b; line-height: 1.5; }
        .sub-section { margin-bottom: 22px; }
        .sub-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #e2e8f0; }
        .page-footer { position: absolute; bottom: 16px; right: 40px; font-size: 10px; color: #cbd5e1; }
        .print-bar { position: fixed; bottom: 0; left: 0; right: 0; background: linear-gradient(135deg, #0f172a, #1e293b); padding: 14px 40px; display: flex; align-items: center; justify-content: space-between; z-index: 100; box-shadow: 0 -4px 20px rgba(0,0,0,0.15); }
        .btn-export { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; padding: 11px 28px; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        @media print { .print-bar { display: none; } body { background: white; } .page { margin: 0; box-shadow: none; } }
    </style>
</head>
<body>

@php
    $p      = $data['primary_color'] ?? '#6366f1';
    $s      = $data['secondary_color'] ?? '#8b5cf6';
    $tam    = (float)($data['tam'] ?? 0);
    $sam    = (float)($data['sam'] ?? 0);
    $som    = (float)($data['som'] ?? 0);
    $price  = (float)($data['price_per_unit'] ?? 1);
    $varC   = (float)($data['variable_cost_per_unit'] ?? 0);
    $fixC   = (float)($data['fixed_costs_monthly'] ?? 0);
    $cm     = $price - $varC;
    $beU    = $cm > 0 ? ceil($fixC / $cm) : 0;
    $beR    = $beU * $price;
    $revs   = $data['revenue_projections'] ?? [];
    $cfs    = $data['cashflow_data'] ?? [];
    $exps   = $data['monthly_expenses'] ?? [];
    $comps  = $data['competitors'] ?? [];
    $team   = $data['team_members'] ?? [];
    $miles  = $data['milestones'] ?? [];
    $dirs   = $data['directors'] ?? [];
    $mgmt   = $data['management_staff'] ?? [];
    $tech   = $data['technical_staff'] ?? [];
    $cvs    = $data['key_cvs'] ?? [];
    $supSrc = $data['supply_sources'] ?? [];
    $rawMat = $data['raw_materials'] ?? [];
    $machs  = $data['machineries'] ?? [];
    $liabs  = $data['liabilities'] ?? [];
    $mpower = $data['manpower'] ?? [];
    $projC  = $data['project_costs'] ?? [];
    $fy     = $data['five_year_projections'] ?? [];
    $logoPath = !empty($data['logo_path']) ? asset($data['logo_path']) : null;
    $photoPaths = !empty($data['photo_paths']) ? array_map(fn($p2) => asset($p2), $data['photo_paths']) : [];
    $pageNum = 1;

    function fmtN($n) {
        $n = (float)$n;
        if ($n >= 1000000000) return '₦'.round($n/1000000000,1).'B';
        if ($n >= 1000000)    return '₦'.round($n/1000000,1).'M';
        if ($n >= 1000)       return '₦'.round($n/1000,1).'K';
        return '₦'.number_format($n);
    }
@endphp

{{-- PAGE 1: COVER --}}
<div class="page cover-page" style="min-height:297mm;">
    <div style="position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,{{ $p }},{{ $s }});"></div>
    <div style="position:relative;z-index:1;">
        @if($logoPath)
        <img src="{{ $logoPath }}" style="height:65px;object-fit:contain;margin-bottom:36px;border-radius:8px;">
        @endif
        <div style="font-size:10px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:{{ $p }};margin-bottom:14px;">Business Plan</div>
        <h1 style="font-size:46px;font-weight:900;line-height:1.1;margin:0 0 14px;letter-spacing:-1px;">{{ $data['company_name'] }}</h1>
        @if(!empty($data['tagline']))<p style="font-size:18px;color:rgba(255,255,255,0.55);margin:0 0 36px;font-weight:300;">{{ $data['tagline'] }}</p>@endif
        <div style="margin-bottom:40px;">
            @foreach(array_filter([$data['industry']??null, ($data['business_stage']??'').' Stage', $data['location']??null]) as $pill)
            <span style="display:inline-block;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);padding:6px 14px;border-radius:999px;font-size:11px;color:rgba(255,255,255,0.75);margin-right:6px;margin-bottom:6px;">{{ $pill }}</span>
            @endforeach
            @if(!empty($data['rc_number']))<span style="display:inline-block;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);padding:6px 14px;border-radius:999px;font-size:11px;color:rgba(255,255,255,0.75);margin-right:6px;">RC: {{ $data['rc_number'] }}</span>@endif
        </div>
        <div style="display:flex;gap:30px;flex-wrap:wrap;">
            @if($tam>0)<div><div style="font-size:22px;font-weight:800;color:{{ $p }};">{{ fmtN($tam) }}</div><div style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.1em;">TAM</div></div>@endif
            @if(!empty($data['funding_required']))<div><div style="font-size:22px;font-weight:800;color:{{ $s }};">{{ fmtN($data['funding_required']) }}</div><div style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.1em;">Raising</div></div>@endif
            @if($beR>0)<div><div style="font-size:22px;font-weight:800;color:#10b981;">{{ fmtN($beR) }}</div><div style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.1em;">Breakeven</div></div>@endif
        </div>
        @if(count($photoPaths)>0)
        <div style="display:flex;gap:10px;margin-top:44px;">
            @foreach($photoPaths as $ph)<img src="{{ $ph }}" style="height:90px;flex:1;object-fit:cover;border-radius:10px;opacity:0.7;">@endforeach
        </div>
        @endif
    </div>
    <div style="position:absolute;bottom:16px;right:40px;font-size:10px;color:rgba(255,255,255,0.25);">Confidential — {{ date('Y') }}</div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:linear-gradient(90deg,{{ $p }},{{ $s }});"></div>
</div>

{{-- PAGE 2: EXECUTIVE SUMMARY --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📋</div><h2>Executive Summary</h2></div>
    @foreach(['problem_statement'=>'Problem','solution'=>'Solution','value_proposition'=>'Value Proposition','target_market'=>'Target Market','revenue_streams'=>'Revenue Streams'] as $k=>$l)
    @if(!empty($data[$k]))<div class="highlight"><h3>{{ $l }}</h3><p>{{ $data[$k] }}</p></div>@endif
    @endforeach
    <div class="grid-3" style="margin-top:18px;">
        <div class="card"><div class="card-title">Business Model</div><div class="card-value" style="font-size:14px;">{{ $data['business_model']??'N/A' }}</div></div>
        <div class="card"><div class="card-title">Funding Required</div><div class="card-value" style="color:{{ $p }};font-size:16px;">{{ !empty($data['funding_required'])?fmtN($data['funding_required']):'Bootstrapped' }}</div></div>
        <div class="card"><div class="card-title">Stage</div><div class="card-value" style="font-size:14px;">{{ $data['business_stage']??'Early' }}</div></div>
    </div>
    @if(!empty($data['use_of_funds']))<div class="highlight" style="margin-top:10px;"><h3>Use of Funds</h3><p>{{ $data['use_of_funds'] }}</p></div>@endif
    <div class="page-footer">{{ $data['company_name'] }} | Executive Summary | 2</div>
</div>

{{-- PAGE 3: COMPANY HISTORY --}}
@if(!empty($data['company_history']) || !empty($data['activities_since_inc']))
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📜</div><h2>Company History & Activities</h2></div>
    @if(!empty($data['company_history']))<div class="highlight"><h3>Company Background</h3><p>{{ $data['company_history'] }}</p></div>@endif
    @if(!empty($data['activities_since_inc']))<div class="highlight"><h3>Activities Since Incorporation</h3><p>{{ $data['activities_since_inc'] }}</p></div>@endif
    @if(!empty($data['project_nature']))<div class="highlight"><h3>Nature of Project</h3><p>{{ $data['project_nature'] }}</p></div>@endif
    @if(!empty($data['expansion_plans']))<div class="highlight"><h3>Expansion / Diversification Plans</h3><p>{{ $data['expansion_plans'] }}</p></div>@endif
    <div class="page-footer">{{ $data['company_name'] }} | Company History | 3</div>
</div>
@endif

{{-- PAGE 4: DIRECTORS & SHAREHOLDING --}}
@if(count($dirs) > 0)
<div class="page section-page">
    <div class="page-header"><div class="section-icon">👔</div><h2>Directors & Shareholding</h2></div>
    <div class="sub-section">
        <div class="sub-title">List of Directors</div>
        <table>
            <thead><tr><th>#</th><th>Name</th><th>Nationality</th><th>Occupation</th><th style="text-align:right;">Shareholding %</th></tr></thead>
            <tbody>
                @foreach($dirs as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="font-weight:600;">{{ $d['name']??'' }}</td>
                    <td>{{ $d['nationality']??'' }}</td>
                    <td>{{ $d['occupation']??'' }}</td>
                    <td style="text-align:right;font-weight:700;color:{{ $p }};">{{ $d['shareholding']??'' }}%</td>
                </tr>
                @endforeach
                <tr style="background:#f8fafc;font-weight:700;">
                    <td colspan="4" style="text-align:right;color:#64748b;">Total Shareholding:</td>
                    <td style="text-align:right;color:{{ $p }};">{{ array_sum(array_column($dirs,'shareholding')) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if(count($mgmt) > 0)
    <div class="sub-section" style="margin-top:24px;">
        <div class="sub-title">Management Staff</div>
        <table>
            <thead><tr><th>Name</th><th>Position</th><th>Qualification</th><th>Experience (Yrs)</th></tr></thead>
            <tbody>
                @foreach($mgmt as $m)<tr><td style="font-weight:600;">{{ $m['name']??'' }}</td><td>{{ $m['position']??'' }}</td><td>{{ $m['qualification']??'' }}</td><td>{{ $m['experience']??'' }}</td></tr>@endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(count($tech) > 0)
    <div class="sub-section" style="margin-top:24px;">
        <div class="sub-title">Technical Staff</div>
        <table>
            <thead><tr><th>Name</th><th>Specialisation</th><th>Qualification</th><th>Experience (Yrs)</th></tr></thead>
            <tbody>
                @foreach($tech as $t)<tr><td style="font-weight:600;">{{ $t['name']??'' }}</td><td>{{ $t['specialisation']??'' }}</td><td>{{ $t['qualification']??'' }}</td><td>{{ $t['experience']??'' }}</td></tr>@endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Directors & Staff | 4</div>
</div>
@endif

{{-- PAGE 5: CVs --}}
@if(count($cvs) > 0)
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📋</div><h2>CVs of Key Personnel</h2></div>
    @foreach($cvs as $cv)
    <div style="border:1px solid #e2e8f0;border-radius:12px;padding:18px;margin-bottom:16px;break-inside:avoid;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #f1f5f9;">
            <div style="width:44px;height:44px;border-radius:50%;background:{{ $p }};color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;flex-shrink:0;">{{ strtoupper(substr($cv['name']??'?',0,1)) }}</div>
            <div>
                <div style="font-size:15px;font-weight:800;color:#0f172a;">{{ $cv['name']??'' }}</div>
                <div style="font-size:12px;color:{{ $p }};font-weight:600;">{{ $cv['position']??'' }}</div>
                @if(!empty($cv['email']))<div style="font-size:11px;color:#94a3b8;">{{ $cv['email'] }}</div>@endif
            </div>
        </div>
        <div class="grid-2">
            @if(!empty($cv['education']))<div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Education</div><p style="font-size:12px;color:#334155;line-height:1.6;white-space:pre-line;">{{ $cv['education'] }}</p></div>@endif
            @if(!empty($cv['experience']))<div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Experience</div><p style="font-size:12px;color:#334155;line-height:1.6;white-space:pre-line;">{{ $cv['experience'] }}</p></div>@endif
        </div>
        @if(!empty($cv['skills']))<div style="margin-top:10px;"><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Skills & Achievements</div><p style="font-size:12px;color:#334155;line-height:1.6;">{{ $cv['skills'] }}</p></div>@endif
    </div>
    @endforeach
    <div class="page-footer">{{ $data['company_name'] }} | Key Personnel CVs | 5</div>
</div>
@endif

{{-- PAGE 6: MARKET ANALYSIS --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">🌍</div><h2>Market Analysis</h2></div>
    <div id="tamChart" style="margin-bottom:16px;"></div>
    <div class="grid-3" style="margin-bottom:18px;">
        <div class="card" style="border-top:3px solid {{ $p }};text-align:center;"><div class="card-title">TAM</div><div class="card-value" style="color:{{ $p }};font-size:18px;">{{ fmtN($tam) }}</div><div style="font-size:10px;color:#94a3b8;margin-top:3px;">Total Addressable</div></div>
        <div class="card" style="border-top:3px solid {{ $s }};text-align:center;"><div class="card-title">SAM</div><div class="card-value" style="color:{{ $s }};font-size:18px;">{{ fmtN($sam) }}</div><div style="font-size:10px;color:#94a3b8;margin-top:3px;">Serviceable Addressable</div></div>
        <div class="card" style="border-top:3px solid #10b981;text-align:center;"><div class="card-title">SOM</div><div class="card-value" style="color:#10b981;font-size:18px;">{{ fmtN($som) }}</div><div style="font-size:10px;color:#94a3b8;margin-top:3px;">Serviceable Obtainable</div></div>
    </div>
    @if(!empty($data['market_opportunity']))<div class="highlight"><h3>Market Opportunity</h3><p>{{ $data['market_opportunity'] }}</p></div>@endif
    @if(!empty($data['supply_analysis']))<div class="highlight"><h3>Supply Analysis</h3><p>{{ $data['supply_analysis'] }}</p></div>@endif
    @if(count($supSrc)>0)
    <div class="sub-section" style="margin-top:14px;">
        <div class="sub-title">Key Supply Sources</div>
        <table><thead><tr><th>Supplier / Source</th><th>Location</th><th>Capacity</th></tr></thead><tbody>
        @foreach($supSrc as $s2)<tr><td>{{ $s2['name']??'' }}</td><td>{{ $s2['location']??'' }}</td><td>{{ $s2['capacity']??'' }}</td></tr>@endforeach
        </tbody></table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Market Analysis | 6</div>
</div>

{{-- PAGE 7: DEMAND & MARKETING --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📊</div><h2>Demand Analysis & Marketing Prospects</h2></div>
    @if(!empty($data['demand_factors']))<div class="highlight"><h3>Factors Influencing Demand</h3><p>{{ $data['demand_factors'] }}</p></div>@endif
    @if(!empty($data['domestic_demand']))<div class="highlight"><h3>Estimate of Domestic Demand</h3><p>{{ $data['domestic_demand'] }}</p></div>@endif
    @if(!empty($data['export_potential']))<div class="highlight"><h3>Export Potentials</h3><p>{{ $data['export_potential'] }}</p></div>@endif
    @if(!empty($data['marketing_arrangements']))<div class="highlight"><h3>Marketing Arrangements</h3><p>{{ $data['marketing_arrangements'] }}</p></div>@endif
    @if(!empty($data['distribution_strategy']))<div class="highlight"><h3>Distribution Strategy</h3><p>{{ $data['distribution_strategy'] }}</p></div>@endif
    @if(!empty($data['selling_price_analysis']))<div class="highlight"><h3>Pricing Analysis (Local vs Import vs Competitors)</h3><p>{{ $data['selling_price_analysis'] }}</p></div>@endif
    @if(count($comps)>0)
    <div class="sub-section" style="margin-top:16px;">
        <div class="sub-title">Competitor Comparison</div>
        <table><thead><tr><th>Competitor</th><th>Pricing</th><th>Strengths</th><th>Weaknesses</th><th>Threat</th></tr></thead><tbody>
        <tr style="background:#f0f4ff;"><td><strong style="color:{{ $p }};">★ {{ $data['company_name'] }}</strong></td><td style="color:#10b981;font-weight:600;">{{ !empty($data['price_per_unit'])?fmtN($data['price_per_unit']):'—' }}</td><td>{{ substr($data['value_proposition']??'',0,50) }}...</td><td style="color:#94a3b8;">N/A</td><td><span class="badge" style="background:#dbeafe;color:#1d4ed8;">Our Co.</span></td></tr>
        @foreach($comps as $c)<tr><td>{{ $c['name']??'' }}</td><td>{{ $c['pricing']??'' }}</td><td>{{ $c['strengths']??'' }}</td><td>{{ $c['weaknesses']??'' }}</td><td><span class="badge {{ str_contains($c['threat']??'','Low')?'badge-low':(str_contains($c['threat']??'','High')?'badge-high':'badge-medium') }}">{{ $c['threat']??'' }}</span></td></tr>@endforeach
        </tbody></table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Demand & Marketing | 7</div>
</div>

{{-- PAGE 8: OPERATIONS --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">⚙️</div><h2>Operations — Raw Materials & Machinery</h2></div>
    @if(count($rawMat)>0)
    <div class="sub-section">
        <div class="sub-title">Sources of Raw Materials</div>
        <table><thead><tr><th>Material</th><th>Supplier</th><th>Location</th><th>Unit Cost (₦)</th><th>Availability</th></tr></thead><tbody>
        @foreach($rawMat as $rm)<tr><td style="font-weight:600;">{{ $rm['material']??'' }}</td><td>{{ $rm['supplier']??'' }}</td><td>{{ $rm['location']??'' }}</td><td>{{ !empty($rm['unit_cost'])?fmtN($rm['unit_cost']):'—' }}</td><td><span class="badge" style="background:#f1f5f9;color:#475569;">{{ $rm['availability']??'' }}</span></td></tr>@endforeach
        </tbody></table>
    </div>
    @endif
    @if(count($machs)>0)
    <div class="sub-section" style="margin-top:20px;">
        <div class="sub-title">List of Machineries / Equipment</div>
        @php $totalMachCost = array_sum(array_map(fn($m) => (float)($m['unit_cost']??0) * (float)($m['quantity']??1), $machs)); @endphp
        <table><thead><tr><th>Item</th><th>Qty</th><th>Unit Cost (₦)</th><th>Total Cost (₦)</th><th>Supplier</th><th>Status</th></tr></thead><tbody>
        @foreach($machs as $m)
        @php $mTotal = (float)($m['unit_cost']??0) * (float)($m['quantity']??1); @endphp
        <tr><td style="font-weight:600;">{{ $m['name']??'' }}</td><td>{{ $m['quantity']??'' }}</td><td>{{ !empty($m['unit_cost'])?fmtN($m['unit_cost']):'—' }}</td><td style="font-weight:600;color:{{ $p }};">{{ fmtN($mTotal) }}</td><td>{{ $m['supplier']??'' }}</td><td><span class="badge" style="background:#f1f5f9;color:#475569;">{{ $m['status']??'' }}</span></td></tr>
        @endforeach
        <tr style="background:#f8fafc;font-weight:700;"><td colspan="3" style="text-align:right;color:#64748b;">Total Machinery Cost:</td><td style="color:{{ $p }};">{{ fmtN($totalMachCost) }}</td><td colspan="2"></td></tr>
        </tbody></table>
    </div>
    @endif
    @if(count($liabs)>0)
    <div class="sub-section" style="margin-top:20px;">
        <div class="sub-title">Outstanding Liabilities</div>
        <table><thead><tr><th>Creditor</th><th>Nature</th><th>Amount (₦)</th><th>Due Date</th></tr></thead><tbody>
        @foreach($liabs as $l)<tr><td style="font-weight:600;">{{ $l['creditor']??'' }}</td><td>{{ $l['nature']??'' }}</td><td style="font-weight:700;color:#ef4444;">{{ !empty($l['amount'])?fmtN($l['amount']):'—' }}</td><td>{{ $l['due_date']??'' }}</td></tr>@endforeach
        <tr style="background:#f8fafc;font-weight:700;"><td colspan="2" style="text-align:right;color:#64748b;">Total Liabilities:</td><td style="color:#ef4444;">{{ fmtN(array_sum(array_column($liabs,'amount'))) }}</td><td></td></tr>
        </tbody></table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Operations | 8</div>
</div>

{{-- PAGE 9: PROJECT COST & MANPOWER --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">🏗️</div><h2>Project Cost & Manpower Plan</h2></div>
    @if(count($projC)>0)
    <div class="sub-section">
        <div class="sub-title">Detailed Project Cost Breakdown</div>
        @php $totalProjCost = array_sum(array_column($projC,'amount')); @endphp
        <table><thead><tr><th>Cost Item</th><th>Description</th><th>Amount (₦)</th><th>Funding Source</th></tr></thead><tbody>
        @foreach($projC as $pc)<tr><td style="font-weight:600;">{{ $pc['item']??'' }}</td><td style="color:#64748b;">{{ $pc['description']??'' }}</td><td style="font-weight:700;color:{{ $p }};">{{ !empty($pc['amount'])?fmtN($pc['amount']):'—' }}</td><td><span class="badge" style="background:#f1f5f9;color:#475569;">{{ $pc['funding_source']??'' }}</span></td></tr>@endforeach
        <tr style="background:#f8fafc;font-weight:700;"><td colspan="2" style="text-align:right;color:#64748b;">Total Project Cost:</td><td style="color:{{ $p }};font-size:14px;">{{ fmtN($totalProjCost) }}</td><td></td></tr>
        </tbody></table>
    </div>
    @if(!empty($data['financial_plan_narrative']))<div class="highlight" style="margin-top:14px;"><h3>Financial Plan</h3><p>{{ $data['financial_plan_narrative'] }}</p></div>@endif
    @endif
    @if(count($mpower)>0)
    <div class="sub-section" style="margin-top:20px;">
        <div class="sub-title">Comprehensive Manpower Plan</div>
        @php $totalStaff = array_sum(array_column($mpower,'count')); $totalPayroll = array_sum(array_map(fn($m) => (float)($m['count']??0)*(float)($m['salary']??0)*12, $mpower)); @endphp
        <table><thead><tr><th>Category</th><th>No. of Staff</th><th>Monthly Salary (₦)</th><th>Annual Cost (₦)</th><th>Qualification</th></tr></thead><tbody>
        @foreach($mpower as $mp)
        @php $annualCost = (float)($mp['count']??0) * (float)($mp['salary']??0) * 12; @endphp
        <tr><td style="font-weight:600;">{{ $mp['category']??'' }}</td><td style="text-align:center;">{{ $mp['count']??'' }}</td><td>{{ !empty($mp['salary'])?fmtN($mp['salary']):'—' }}</td><td style="font-weight:700;color:{{ $p }};">{{ fmtN($annualCost) }}</td><td style="color:#64748b;">{{ $mp['qualification']??'' }}</td></tr>
        @endforeach
        <tr style="background:#f8fafc;font-weight:700;"><td style="font-weight:700;">TOTAL</td><td style="text-align:center;">{{ $totalStaff }}</td><td></td><td style="color:{{ $p }};font-size:14px;">{{ fmtN($totalPayroll) }}</td><td></td></tr>
        </tbody></table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Project Cost & Manpower | 9</div>
</div>

{{-- PAGE 10: YEAR 1 FINANCIAL CHARTS --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📈</div><h2>Year 1 Financial Projections</h2></div>
    <div class="grid-3" style="margin-bottom:18px;">
        <div class="card"><div class="card-title">Startup Costs</div><div class="card-value" style="color:{{ $p }};">{{ fmtN($data['startup_costs']??0) }}</div></div>
        <div class="card"><div class="card-title">Breakeven (Units/Mo)</div><div class="card-value" style="color:#f59e0b;">{{ number_format($beU) }}</div></div>
        <div class="card"><div class="card-title">Breakeven Revenue</div><div class="card-value" style="color:#10b981;">{{ fmtN($beR) }}</div></div>
    </div>
    <div style="margin-bottom:20px;"><div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;margin-bottom:10px;">Revenue Projection — Year 1</div><div id="revenueChart"></div></div>
    <div class="grid-2">
        <div><div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;margin-bottom:10px;">Expense Breakdown</div><div id="expensePieChart"></div></div>
        <div style="padding-top:30px;">
            @foreach($exps as $i => $exp)
            @if(!empty($exp['category']) && $exp['amount']>0)
            @php $pct = array_sum(array_column($exps,'amount'))>0 ? round((float)$exp['amount']/array_sum(array_column($exps,'amount'))*100,1) : 0; @endphp
            <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 10px;background:#f8fafc;border-radius:7px;border:1px solid #e2e8f0;margin-bottom:5px;">
                <span style="font-size:12px;color:#334155;">{{ $exp['category'] }}</span>
                <span style="font-size:12px;font-weight:700;">{{ fmtN($exp['amount']) }} <span style="color:#94a3b8;font-weight:400;">({{ $pct }}%)</span></span>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="page-footer">{{ $data['company_name'] }} | Year 1 Projections | 10</div>
</div>

{{-- PAGE 11: CASHFLOW & BREAKEVEN --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">💹</div><h2>Cashflow & Breakeven Analysis</h2></div>
    <div style="margin-bottom:22px;"><div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;margin-bottom:10px;">Monthly Cashflow — Year 1</div><div id="cashflowChart"></div></div>
    <div><div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;margin-bottom:10px;">Breakeven Analysis</div><div id="breakevenChart"></div></div>
    <div class="page-footer">{{ $data['company_name'] }} | Cashflow & Breakeven | 11</div>
</div>

{{-- PAGE 12: 5-YEAR P&L --}}
@if(!empty($fy['pl']))
<div class="page section-page">
    <div class="page-header"><div class="section-icon">📊</div><h2>5-Year Profit & Loss Account</h2></div>
    <div id="fiveYearRevenueChart" style="margin-bottom:20px;"></div>
    <table>
        <thead><tr><th>Item</th>@for($y=1;$y<=5;$y++)<th style="text-align:right;">Year {{ $y }}</th>@endfor</tr></thead>
        <tbody>
        @foreach(['revenue'=>'Revenue / Turnover','cogs'=>'Cost of Goods Sold','gross_profit'=>'Gross Profit','operating_expenses'=>'Operating Expenses','ebitda'=>'EBITDA','depreciation'=>'Depreciation','interest'=>'Interest Expense','ebt'=>'Profit Before Tax','tax'=>'Tax','net_profit'=>'Net Profit After Tax'] as $k=>$l)
        @php $isHL = in_array($k,['gross_profit','ebitda','net_profit']); @endphp
        <tr style="{{ $isHL ? 'background:#f8fafc;' : '' }}">
            <td style="font-weight:{{ $isHL?'700':'500' }};{{ $isHL ? 'color:#0f172a;' : 'color:#334155;' }}">{{ $l }}</td>
            @for($y=1;$y<=5;$y++)
            @php $val = (float)(($fy['pl'][$k][$y-1] ?? 0)); @endphp
            <td style="text-align:right;font-weight:{{ $isHL?'700':'400' }};color:{{ $isHL?$p:'#334155' }};">{{ fmtN($val) }}</td>
            @endfor
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="page-footer">{{ $data['company_name'] }} | 5-Year P&L | 12</div>
</div>
@endif

{{-- PAGE 13: 5-YEAR CASHFLOW & BALANCE SHEET --}}
@if(!empty($fy['cf']) || !empty($fy['bs']))
<div class="page section-page">
    <div class="page-header"><div class="section-icon">🏦</div><h2>5-Year Cashflow & Balance Sheet</h2></div>
    @if(!empty($fy['cf']))
    <div class="sub-section">
        <div class="sub-title">Cash Flow Statement</div>
        <table>
            <thead><tr><th>Item</th>@for($y=1;$y<=5;$y++)<th style="text-align:right;">Year {{ $y }}</th>@endfor</tr></thead>
            <tbody>
            @foreach(['operating_cashflow'=>'Operating Cash Flow','investing_cashflow'=>'Investing Cash Flow','financing_cashflow'=>'Financing Cash Flow','net_cashflow'=>'Net Cash Flow','opening_balance'=>'Opening Cash Balance','closing_balance'=>'Closing Cash Balance'] as $k=>$l)
            @php $isHL = in_array($k,['net_cashflow','closing_balance']); @endphp
            <tr style="{{ $isHL ? 'background:#f8fafc;' : '' }}">
                <td style="font-weight:{{ $isHL?'700':'500' }};">{{ $l }}</td>
                @for($y=1;$y<=5;$y++)
                @php $val = (float)(($fy['cf'][$k][$y-1] ?? 0)); $col = $val>=0 ? '#10b981' : '#ef4444'; @endphp
                <td style="text-align:right;font-weight:{{ $isHL?'700':'400' }};color:{{ $isHL?$col:'#334155' }};">{{ fmtN($val) }}</td>
                @endfor
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @if(!empty($fy['bs']))
    <div class="sub-section" style="margin-top:20px;">
        <div class="sub-title">Balance Sheet</div>
        <table>
            <thead><tr><th>Item</th>@for($y=1;$y<=5;$y++)<th style="text-align:right;">Year {{ $y }}</th>@endfor</tr></thead>
            <tbody>
            @foreach(['fixed_assets'=>'Fixed Assets','current_assets'=>'Current Assets','total_assets'=>'Total Assets','current_liabilities'=>'Current Liabilities','long_term_liabilities'=>'Long-Term Liabilities','equity'=>'Shareholders Equity','total_liabilities_equity'=>'Total Liabilities & Equity'] as $k=>$l)
            @php $isHL = in_array($k,['total_assets','total_liabilities_equity']); @endphp
            <tr style="{{ $isHL ? 'background:#f8fafc;' : '' }}">
                <td style="font-weight:{{ $isHL?'700':'500' }};">{{ $l }}</td>
                @for($y=1;$y<=5;$y++)
                @php $val = (float)(($fy['bs'][$k][$y-1] ?? 0)); @endphp
                <td style="text-align:right;font-weight:{{ $isHL?'700':'400' }};color:{{ $isHL?$p:'#334155' }};">{{ fmtN($val) }}</td>
                @endfor
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | 5-Year Cashflow & Balance Sheet | 13</div>
</div>
@endif

{{-- PAGE 14: TEAM & MILESTONES --}}
<div class="page section-page">
    <div class="page-header"><div class="section-icon">👥</div><h2>Team & Roadmap</h2></div>
    @if(count($team)>0)
    <div class="sub-section">
        <div class="sub-title">Core Team</div>
        <div style="display:grid;grid-template-columns:repeat({{ min(count($team),3) }},1fr);gap:14px;margin-bottom:20px;">
            @foreach($team as $m)
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px;text-align:center;">
                <div style="width:46px;height:46px;border-radius:50%;background:{{ $p }};color:white;font-size:18px;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">{{ strtoupper(substr($m['name']??'T',0,1)) }}</div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $m['name']??'' }}</div>
                <div style="font-size:11px;color:#64748b;">{{ $m['role']??'' }}</div>
                @if(!empty($m['bio']))<div style="font-size:10px;color:#94a3b8;margin-top:5px;line-height:1.5;">{{ substr($m['bio'],0,100) }}</div>@endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @if(count($miles)>0)
    <div class="sub-title">Growth Roadmap & Milestones</div>
    <div class="timeline">
        @foreach($miles as $ms)
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">{{ $ms['date']??'' }}</div>
            <div class="timeline-title">{{ $ms['title']??'' }}</div>
            @if(!empty($ms['description']))<div class="timeline-desc">{{ $ms['description'] }}</div>@endif
        </div>
        @endforeach
    </div>
    @endif
    <div class="page-footer">{{ $data['company_name'] }} | Team & Roadmap | 14</div>
</div>

{{-- PRINT BAR --}}
<div class="print-bar">
    <div style="display:flex;align-items:center;gap:16px;">
        <a href="{{ route('home') }}" style="color:#94a3b8;text-decoration:none;font-size:13px;">← Edit Plan</a>
        <span style="color:#334155;">|</span>
        <span style="color:#94a3b8;font-size:13px;">{{ $data['company_name'] }} — Business Plan</span>
    </div>
    <form action="{{ route('export.pdf') }}" method="POST">
        @csrf
        <button type="submit" class="btn-export">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 16l-4-4h3V4h2v8h3l-4 4z"/><path d="M5 20h14"/></svg>
            Export to PDF
        </button>
    </form>
</div>
<div style="height:70px;"></div>

<script>
const P = '{{ $p }}', S = '{{ $s }}';
const months = {!! json_encode(array_column($revs,'label')) !!};
const revenueData = {!! json_encode(array_map(fn($r)=>(float)($r['revenue']??0),$revs)) !!};
const inflows  = {!! json_encode(array_map(fn($c)=>(float)($c['inflow']??0),$cfs)) !!};
const outflows = {!! json_encode(array_map(fn($c)=>(float)($c['outflow']??0),$cfs)) !!};
const netCF    = inflows.map((v,i)=>v-outflows[i]);
const expCats  = {!! json_encode(array_column($exps,'category')) !!};
const expAmts  = {!! json_encode(array_map(fn($e)=>(float)($e['amount']??0),$exps)) !!};
const fixedC   = {{ $fixC }}, price = {{ $price }}, varC = {{ $varC }};
const beUnits  = {{ $beU }};
const tamV     = {{ $tam }}, samV = {{ $sam }}, somV = {{ $som }};

// Revenue chart
new ApexCharts(document.getElementById('revenueChart'),{
    series:[{name:'Revenue',data:revenueData}],
    chart:{type:'area',height:180,toolbar:{show:false}},
    dataLabels:{enabled:false}, stroke:{curve:'smooth',width:3},
    fill:{type:'gradient',gradient:{opacityFrom:0.35,opacityTo:0}},
    colors:[P], xaxis:{categories:months,labels:{style:{fontSize:'10px',colors:'#94a3b8'}}},
    yaxis:{labels:{formatter:v=>'₦'+(v>=1000?(v/1000).toFixed(0)+'K':v),style:{fontSize:'10px',colors:'#94a3b8'}}},
    grid:{borderColor:'#f1f5f9'}, tooltip:{y:{formatter:v=>'₦'+v.toLocaleString()}}
}).render();

// Expense pie
if(expAmts.some(v=>v>0)){
    new ApexCharts(document.getElementById('expensePieChart'),{
        series:expAmts, labels:expCats,
        chart:{type:'donut',height:200,toolbar:{show:false}},
        colors:[P,S,'#10b981','#f59e0b','#ef4444','#06b6d4'],
        legend:{position:'bottom',fontSize:'10px'},
        dataLabels:{formatter:v=>v.toFixed(1)+'%'},
        plotOptions:{pie:{donut:{size:'60%'}}}
    }).render();
}

// Cashflow chart
new ApexCharts(document.getElementById('cashflowChart'),{
    series:[{name:'Inflow',data:inflows},{name:'Outflow',data:outflows},{name:'Net',type:'line',data:netCF}],
    chart:{type:'bar',height:200,toolbar:{show:false}},
    colors:['#10b981','#ef4444',P], stroke:{width:[0,0,3],curve:'smooth'},
    plotOptions:{bar:{columnWidth:'60%',borderRadius:3}}, dataLabels:{enabled:false},
    xaxis:{categories:months,labels:{style:{fontSize:'10px',colors:'#94a3b8'}}},
    yaxis:{labels:{formatter:v=>'₦'+(Math.abs(v)>=1000?(v/1000).toFixed(0)+'K':v),style:{fontSize:'10px',colors:'#94a3b8'}}},
    legend:{position:'top',fontSize:'11px'}, grid:{borderColor:'#f1f5f9'}
}).render();

// Breakeven
const maxU = Math.max(beUnits*2,50);
const step = Math.max(1,Math.floor(maxU/10));
const uRange = Array.from({length:11},(_,i)=>i*step);
new ApexCharts(document.getElementById('breakevenChart'),{
    series:[{name:'Total Revenue',data:uRange.map(u=>u*price)},{name:'Total Costs',data:uRange.map(u=>fixedC+u*varC)}],
    chart:{type:'line',height:190,toolbar:{show:false}},
    colors:['#10b981','#ef4444'], stroke:{width:3,curve:'straight',dashArray:[0,6]},
    xaxis:{categories:uRange.map(u=>u+' units'),labels:{style:{fontSize:'10px',colors:'#94a3b8'}}},
    yaxis:{labels:{formatter:v=>'₦'+(v>=1000?(v/1000).toFixed(0)+'K':v),style:{fontSize:'10px',colors:'#94a3b8'}}},
    legend:{position:'top',fontSize:'11px'}, grid:{borderColor:'#f1f5f9'}
}).render();

// TAM/SAM/SOM radial
const samPct = tamV>0?parseFloat((samV/tamV*100).toFixed(1)):10;
const somPct = tamV>0?parseFloat((somV/tamV*100).toFixed(1)):1;
new ApexCharts(document.getElementById('tamChart'),{
    series:[100,samPct||10,somPct||1],
    labels:['TAM','SAM','SOM'],
    chart:{type:'radialBar',height:200,toolbar:{show:false}},
    colors:[P,S,'#10b981'],
    plotOptions:{radialBar:{hollow:{size:'30%'},track:{background:'#f1f5f9'},
        dataLabels:{name:{fontSize:'11px'},value:{fontSize:'12px',formatter:(v,o)=>['TAM','SAM','SOM'][o.seriesIndex]}}}},
    legend:{show:true,position:'bottom',fontSize:'10px'}
}).render();

// 5-Year Revenue chart
@if(!empty($fy['pl']['revenue']))
const fy5Rev = {!! json_encode(array_map('floatval', $fy['pl']['revenue'] ?? [0,0,0,0,0])) !!};
const fy5Net = {!! json_encode(array_map('floatval', $fy['pl']['net_profit'] ?? [0,0,0,0,0])) !!};
new ApexCharts(document.getElementById('fiveYearRevenueChart'),{
    series:[{name:'Revenue',data:fy5Rev},{name:'Net Profit',data:fy5Net}],
    chart:{type:'bar',height:200,toolbar:{show:false}},
    colors:[P,'#10b981'], plotOptions:{bar:{columnWidth:'55%',borderRadius:4}},
    dataLabels:{enabled:false},
    xaxis:{categories:['Year 1','Year 2','Year 3','Year 4','Year 5'],labels:{style:{fontSize:'11px',colors:'#94a3b8'}}},
    yaxis:{labels:{formatter:v=>'₦'+(v>=1000000?(v/1000000).toFixed(1)+'M':v>=1000?(v/1000).toFixed(0)+'K':v),style:{fontSize:'10px',colors:'#94a3b8'}}},
    legend:{position:'top',fontSize:'11px'}, grid:{borderColor:'#f1f5f9'}
}).render();
@endif
</script>
</body>
</html>
