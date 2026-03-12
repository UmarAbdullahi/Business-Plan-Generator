<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; background: white; }

@page { margin: 14mm 16mm; }

/* ── Utilities ── */
.page-break { page-break-after: always; }
.no-break   { page-break-inside: avoid; }

/* ── Cover ── */
.cover { background: #0f172a; color: white; padding: 60px 50px; min-height: 240mm; position: relative; }
.cover-accent { height: 5px; background: linear-gradient(90deg, {{ $primary }}, {{ $secondary }}); margin-bottom: 0; }
.cover h1 { font-size: 34px; font-weight: 900; color: white; margin: 0 0 10px; line-height: 1.15; }
.cover-tagline { font-size: 14px; color: rgba(255,255,255,0.5); margin-bottom: 30px; font-weight: 300; }
.pill { display: inline-block; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); padding: 4px 12px; border-radius: 999px; font-size: 9px; color: rgba(255,255,255,0.7); margin-right: 5px; margin-bottom: 5px; }
.kpi-row { margin-top: 36px; display: table; width: 100%; }
.kpi { display: table-cell; padding-right: 30px; }
.kpi-val { font-size: 20px; font-weight: 900; color: {{ $primary }}; }
.kpi-lbl { font-size: 8px; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 2px; }
.confidential { position: absolute; bottom: 14px; right: 20px; font-size: 8px; color: rgba(255,255,255,0.2); }

/* ── Section pages ── */
.section { padding: 0 0 20px; }
.page-header { display: table; width: 100%; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid {{ $primary }}; }
.page-header-icon { display: table-cell; width: 32px; }
.icon-box { width: 30px; height: 30px; background: {{ $primary }}; border-radius: 7px; text-align: center; line-height: 30px; font-size: 14px; }
.page-header-text { display: table-cell; vertical-align: middle; padding-left: 8px; }
.page-header-text h2 { font-size: 16px; font-weight: 900; color: #0f172a; }
.page-num { display: table-cell; text-align: right; vertical-align: middle; font-size: 9px; color: #94a3b8; }

/* ── Cards / highlights ── */
.card-row { display: table; width: 100%; margin-bottom: 14px; }
.card-cell { display: table-cell; padding-right: 10px; }
.card-cell:last-child { padding-right: 0; }
.card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
.card-title { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 4px; }
.card-value { font-size: 16px; font-weight: 900; color: #0f172a; }

.highlight { border-left: 3px solid {{ $primary }}; padding: 9px 12px; background: #f8fafc; border-radius: 0 8px 8px 0; margin-bottom: 10px; }
.highlight h3 { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; margin-bottom: 4px; }
.highlight p { font-size: 10px; color: #334155; line-height: 1.6; }

/* ── Tables ── */
.data-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; font-size: 10px; }
.data-table th { background: #f1f5f9; padding: 6px 8px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
.data-table td { padding: 7px 8px; border-bottom: 1px solid #f1f5f9; color: #334155; }
.data-table tr.hl td { background: #f8fafc; font-weight: 700; }
.data-table tr.total td { background: #f1f5f9; font-weight: 700; }

.badge { display: inline-block; padding: 2px 7px; border-radius: 999px; font-size: 8px; font-weight: 700; }
.badge-low    { background: #dcfce7; color: #166534; }
.badge-medium { background: #fef9c3; color: #854d0e; }
.badge-high   { background: #fee2e2; color: #991b1b; }
.badge-neutral { background: #f1f5f9; color: #475569; }

/* ── Timeline ── */
.timeline-item { margin-bottom: 14px; padding-left: 16px; border-left: 2px solid {{ $primary }}; }
.t-date  { font-size: 8px; font-weight: 700; color: {{ $primary }}; text-transform: uppercase; margin-bottom: 2px; }
.t-title { font-size: 11px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
.t-desc  { font-size: 10px; color: #64748b; line-height: 1.5; }

/* ── Staff card grid ── */
.team-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: table-cell; vertical-align: top; width: 33%; padding-right: 10px; }
.team-avatar { width: 36px; height: 36px; border-radius: 50%; background: {{ $primary }}; color: white; font-size: 15px; font-weight: 900; text-align: center; line-height: 36px; margin-bottom: 7px; }
.team-name { font-size: 11px; font-weight: 700; color: #0f172a; }
.team-role { font-size: 9px; color: {{ $primary }}; font-weight: 600; margin-bottom: 4px; }
.team-bio  { font-size: 9px; color: #64748b; line-height: 1.5; }

/* ── CV block ── */
.cv-block { border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; margin-bottom: 12px; }
.cv-header { display: table; width: 100%; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9; }
.cv-avatar { display: table-cell; width: 40px; vertical-align: middle; }
.av-circle { width: 36px; height: 36px; border-radius: 50%; background: {{ $primary }}; color: white; font-size: 15px; font-weight: 900; text-align: center; line-height: 36px; }
.cv-info { display: table-cell; vertical-align: middle; padding-left: 10px; }
.cv-name { font-size: 13px; font-weight: 800; color: #0f172a; }
.cv-position { font-size: 10px; color: {{ $primary }}; font-weight: 600; }
.cv-email { font-size: 9px; color: #94a3b8; }
.cv-grid { display: table; width: 100%; }
.cv-col { display: table-cell; vertical-align: top; padding-right: 12px; width: 50%; }
.cv-col:last-child { padding-right: 0; }
.cv-section-title { font-size: 8px; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px; letter-spacing: 0.06em; }
.cv-text { font-size: 10px; color: #334155; line-height: 1.6; white-space: pre-wrap; }

/* ── Sub-section title ── */
.sub-title { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 10px; margin-top: 16px; }

/* ── 5-year table ── */
.fy-table { width: 100%; border-collapse: collapse; font-size: 9px; }
.fy-table th { background: #f1f5f9; padding: 5px 7px; font-size: 8px; font-weight: 700; text-transform: uppercase; color: #64748b; }
.fy-table th:not(:first-child) { text-align: right; }
.fy-table td { padding: 5px 7px; border-bottom: 1px solid #f5f5f5; color: #334155; }
.fy-table td:not(:first-child) { text-align: right; }
.fy-table tr.hl td { background: #f8fafc; font-weight: 700; color: #0f172a; }
.fy-table tr.section-hd td { background: #eff6ff; color: {{ $primary }}; font-weight: 700; font-size: 8px; text-transform: uppercase; letter-spacing: 0.06em; }

/* ── Chart bars (static HTML chart) ── */
.bar-track { background: #f1f5f9; border-radius: 4px; height: 12px; margin-bottom: 1px; overflow: hidden; }
.bar-fill  { height: 12px; border-radius: 4px; }
.chart-label { font-size: 9px; color: #64748b; margin-bottom: 2px; }
.chart-value { font-size: 9px; color: #0f172a; font-weight: 600; text-align: right; }
</style>
</head>
<body>

@php
    function fmtN($n) {
        $n = (float)$n;
        if ($n >= 1000000000) return '₦'.round($n/1000000000,1).'B';
        if ($n >= 1000000)    return '₦'.round($n/1000000,1).'M';
        if ($n >= 1000)       return '₦'.round($n/1000,1).'K';
        return '₦'.number_format($n,0);
    }

    $p       = $data['primary_color']   ?? '#6366f1';
    $s       = $data['secondary_color'] ?? '#8b5cf6';
    $primary = $p; $secondary = $s;

    $revs    = $data['revenue_projections'] ?? [];
    $cfs     = $data['cashflow_data']       ?? [];
    $exps    = $data['monthly_expenses']    ?? [];
    $comps   = $data['competitors']         ?? [];
    $team    = $data['team_members']        ?? [];
    $miles   = $data['milestones']          ?? [];
    $dirs    = $data['directors']           ?? [];
    $mgmt    = $data['management_staff']    ?? [];
    $tech    = $data['technical_staff']     ?? [];
    $cvs     = $data['key_cvs']             ?? [];
    $supSrc  = $data['supply_sources']      ?? [];
    $rawMat  = $data['raw_materials']       ?? [];
    $machs   = $data['machineries']         ?? [];
    $liabs   = $data['liabilities']         ?? [];
    $mpower  = $data['manpower']            ?? [];
    $projC   = $data['project_costs']       ?? [];
    $fy      = $data['five_year_projections'] ?? [];

    $price   = (float)($data['price_per_unit']           ?? 1);
    $varC    = (float)($data['variable_cost_per_unit']   ?? 0);
    $fixC    = (float)($data['fixed_costs_monthly']      ?? 0);
    $cm      = $price - $varC;
    $beU     = $cm > 0 ? ceil($fixC / $cm) : 0;
    $beR     = $beU * $price;

    $maxRev  = max(array_merge([1], array_map(fn($r)=>(float)($r['revenue']??0), $revs)));
    $maxInf  = max(array_merge([1], array_map(fn($c)=>(float)($c['inflow']??0), $cfs)));
    $maxOut  = max(array_merge([1], array_map(fn($c)=>(float)($c['outflow']??0), $cfs)));
    $maxCF   = max($maxInf, $maxOut, 1);
    $totalExp = array_sum(array_column($exps,'amount')) ?: 1;
@endphp

{{-- ══════════════ COVER ══════════════ --}}
<div class="cover-accent"></div>
<div class="cover page-break">
    @if(!empty($data['logo_base64']))
    <img src="{{ $data['logo_base64'] }}" style="height:55px;object-fit:contain;margin-bottom:28px;border-radius:6px;">
    @endif
    <div style="font-size:8px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:{{ $p }};margin-bottom:10px;">Business Plan</div>
    <h1>{{ $data['company_name'] }}</h1>
    @if(!empty($data['tagline']))<div class="cover-tagline">{{ $data['tagline'] }}</div>@endif

    <div style="margin-bottom:24px;">
        @foreach(array_filter([$data['industry']??null, ($data['business_stage']??'').' Stage', $data['location']??null, !empty($data['rc_number'])?'RC: '.$data['rc_number']:null]) as $pill)
        <span class="pill">{{ $pill }}</span>
        @endforeach
    </div>

    <div class="kpi-row">
        @if((float)($data['tam']??0)>0)
        <div class="kpi"><div class="kpi-val">{{ fmtN($data['tam']) }}</div><div class="kpi-lbl">Total Addressable Market</div></div>
        @endif
        @if(!empty($data['funding_required']))
        <div class="kpi"><div class="kpi-val" style="color:{{ $s }};">{{ fmtN($data['funding_required']) }}</div><div class="kpi-lbl">Funding Required</div></div>
        @endif
        @if($beR>0)
        <div class="kpi"><div class="kpi-val" style="color:#10b981;">{{ fmtN($beR) }}</div><div class="kpi-lbl">Monthly Breakeven</div></div>
        @endif
    </div>

    @if(!empty($data['photos_base64']))
    <div style="margin-top:40px;display:table;width:100%;">
        @foreach($data['photos_base64'] as $ph)
        <div style="display:table-cell;padding-right:8px;"><img src="{{ $ph }}" style="width:100%;height:75px;object-fit:cover;border-radius:8px;opacity:0.65;"></div>
        @endforeach
    </div>
    @endif
    <div class="confidential">Confidential — {{ date('Y') }}</div>
</div>

{{-- ══════════════ PAGE 2: EXECUTIVE SUMMARY ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📋</div></div>
        <div class="page-header-text"><h2>Executive Summary</h2></div>
        <div class="page-num">Page 2</div>
    </div>
    @foreach(['problem_statement'=>'Problem Statement','solution'=>'Solution','value_proposition'=>'Value Proposition','target_market'=>'Target Market','revenue_streams'=>'Revenue Streams','use_of_funds'=>'Use of Funds'] as $k=>$l)
    @if(!empty($data[$k]))<div class="highlight"><h3>{{ $l }}</h3><p>{{ $data[$k] }}</p></div>@endif
    @endforeach
    <div class="card-row">
        <div class="card-cell" style="width:33%"><div class="card"><div class="card-title">Business Model</div><div class="card-value" style="font-size:12px;">{{ $data['business_model']??'—' }}</div></div></div>
        <div class="card-cell" style="width:33%"><div class="card"><div class="card-title">Funding Required</div><div class="card-value" style="font-size:13px;color:{{ $p }};">{{ !empty($data['funding_required'])?fmtN($data['funding_required']):'Bootstrapped' }}</div></div></div>
        <div class="card-cell" style="width:33%"><div class="card"><div class="card-title">Stage</div><div class="card-value" style="font-size:12px;">{{ $data['business_stage']??'Early' }}</div></div></div>
    </div>
</div>

{{-- ══════════════ PAGE 3: COMPANY HISTORY ══════════════ --}}
@if(!empty($data['company_history']) || !empty($data['activities_since_inc']))
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📜</div></div>
        <div class="page-header-text"><h2>Company History & Activities</h2></div>
        <div class="page-num">Page 3</div>
    </div>
    @if(!empty($data['rc_number']) || !empty($data['incorporation_date']))
    <div class="card-row" style="margin-bottom:14px;">
        @if(!empty($data['rc_number']))<div class="card-cell"><div class="card"><div class="card-title">RC Number</div><div class="card-value" style="font-size:13px;">{{ $data['rc_number'] }}</div></div></div>@endif
        @if(!empty($data['incorporation_date']))<div class="card-cell"><div class="card"><div class="card-title">Date of Incorporation</div><div class="card-value" style="font-size:13px;">{{ $data['incorporation_date'] }}</div></div></div>@endif
        @if(!empty($data['location']))<div class="card-cell"><div class="card"><div class="card-title">Headquarters</div><div class="card-value" style="font-size:13px;">{{ $data['location'] }}</div></div></div>@endif
    </div>
    @endif
    @foreach(['company_history'=>'Company Background','activities_since_inc'=>'Activities Since Incorporation','project_nature'=>'Nature of Project','expansion_plans'=>'Expansion & Diversification Plans'] as $k=>$l)
    @if(!empty($data[$k]))<div class="highlight"><h3>{{ $l }}</h3><p>{{ $data[$k] }}</p></div>@endif
    @endforeach
</div>
@endif

{{-- ══════════════ PAGE 4: DIRECTORS & STAFF ══════════════ --}}
@if(count($dirs)>0 || count($mgmt)>0 || count($tech)>0)
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">👔</div></div>
        <div class="page-header-text"><h2>Directors, Management & Technical Staff</h2></div>
        <div class="page-num">Page 4</div>
    </div>

    @if(count($dirs)>0)
    <div class="sub-title">List of Directors & Shareholding</div>
    <table class="data-table">
        <thead><tr><th>#</th><th>Name</th><th>Nationality</th><th>Occupation</th><th style="text-align:right;">Shareholding %</th></tr></thead>
        <tbody>
        @foreach($dirs as $i=>$d)
        <tr><td>{{ $i+1 }}</td><td style="font-weight:700;">{{ $d['name']??'' }}</td><td>{{ $d['nationality']??'' }}</td><td>{{ $d['occupation']??'' }}</td><td style="text-align:right;font-weight:700;color:{{ $p }};">{{ $d['shareholding']??'' }}%</td></tr>
        @endforeach
        <tr class="total"><td colspan="4" style="text-align:right;">Total:</td><td style="text-align:right;color:{{ $p }};">{{ array_sum(array_column($dirs,'shareholding')) }}%</td></tr>
        </tbody>
    </table>
    @endif

    @if(count($mgmt)>0)
    <div class="sub-title">Management Staff</div>
    <table class="data-table">
        <thead><tr><th>Name</th><th>Position</th><th>Qualification</th><th>Experience (Yrs)</th></tr></thead>
        <tbody>
        @foreach($mgmt as $m)<tr><td style="font-weight:700;">{{ $m['name']??'' }}</td><td>{{ $m['position']??'' }}</td><td>{{ $m['qualification']??'' }}</td><td>{{ $m['experience']??'' }}</td></tr>@endforeach
        </tbody>
    </table>
    @endif

    @if(count($tech)>0)
    <div class="sub-title">Technical Staff</div>
    <table class="data-table">
        <thead><tr><th>Name</th><th>Specialisation</th><th>Qualification</th><th>Experience (Yrs)</th></tr></thead>
        <tbody>
        @foreach($tech as $t)<tr><td style="font-weight:700;">{{ $t['name']??'' }}</td><td>{{ $t['specialisation']??'' }}</td><td>{{ $t['qualification']??'' }}</td><td>{{ $t['experience']??'' }}</td></tr>@endforeach
        </tbody>
    </table>
    @endif
</div>
@endif

{{-- ══════════════ PAGE 5: CVs ══════════════ --}}
@if(count($cvs)>0)
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📋</div></div>
        <div class="page-header-text"><h2>Curriculum Vitae — Key Personnel</h2></div>
        <div class="page-num">Page 5</div>
    </div>
    @foreach($cvs as $cv)
    <div class="cv-block no-break">
        <div class="cv-header">
            <div class="cv-avatar"><div class="av-circle">{{ strtoupper(substr($cv['name']??'?',0,1)) }}</div></div>
            <div class="cv-info">
                <div class="cv-name">{{ $cv['name']??'' }}</div>
                <div class="cv-position">{{ $cv['position']??'' }}</div>
                @if(!empty($cv['email']))<div class="cv-email">{{ $cv['email'] }}</div>@endif
            </div>
        </div>
        <div class="cv-grid">
            @if(!empty($cv['education']))<div class="cv-col"><div class="cv-section-title">Education / Qualifications</div><div class="cv-text">{{ $cv['education'] }}</div></div>@endif
            @if(!empty($cv['experience']))<div class="cv-col"><div class="cv-section-title">Professional Experience</div><div class="cv-text">{{ $cv['experience'] }}</div></div>@endif
        </div>
        @if(!empty($cv['skills']))<div style="margin-top:8px;"><div class="cv-section-title">Skills & Achievements</div><div class="cv-text">{{ $cv['skills'] }}</div></div>@endif
    </div>
    @endforeach
</div>
@endif

{{-- ══════════════ PAGE 6: MARKET ANALYSIS ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">🌍</div></div>
        <div class="page-header-text"><h2>Market Analysis</h2></div>
        <div class="page-num">Page 6</div>
    </div>
    <div class="card-row">
        <div class="card-cell"><div class="card" style="border-top:3px solid {{ $p }};text-align:center;"><div class="card-title">TAM</div><div class="card-value" style="color:{{ $p }};font-size:14px;">{{ fmtN($data['tam']??0) }}</div><div style="font-size:8px;color:#94a3b8;margin-top:2px;">Total Addressable</div></div></div>
        <div class="card-cell"><div class="card" style="border-top:3px solid {{ $s }};text-align:center;"><div class="card-title">SAM</div><div class="card-value" style="color:{{ $s }};font-size:14px;">{{ fmtN($data['sam']??0) }}</div><div style="font-size:8px;color:#94a3b8;margin-top:2px;">Serviceable</div></div></div>
        <div class="card-cell"><div class="card" style="border-top:3px solid #10b981;text-align:center;"><div class="card-title">SOM</div><div class="card-value" style="color:#10b981;font-size:14px;">{{ fmtN($data['som']??0) }}</div><div style="font-size:8px;color:#94a3b8;margin-top:2px;">Obtainable</div></div></div>
    </div>
    @if(!empty($data['market_opportunity']))<div class="highlight"><h3>Market Opportunity</h3><p>{{ $data['market_opportunity'] }}</p></div>@endif
    @if(!empty($data['supply_analysis']))<div class="highlight"><h3>Supply Analysis</h3><p>{{ $data['supply_analysis'] }}</p></div>@endif
    @if(count($supSrc)>0)
    <div class="sub-title">Key Supply Sources</div>
    <table class="data-table"><thead><tr><th>Supplier / Source</th><th>Location</th><th>Capacity</th></tr></thead><tbody>
    @foreach($supSrc as $ss)<tr><td>{{ $ss['name']??'' }}</td><td>{{ $ss['location']??'' }}</td><td>{{ $ss['capacity']??'' }}</td></tr>@endforeach
    </tbody></table>
    @endif
    @foreach(['demand_factors'=>'Factors Influencing Demand','domestic_demand'=>'Estimate of Domestic Demand','export_potential'=>'Export Potentials'] as $k=>$l)
    @if(!empty($data[$k]))<div class="highlight"><h3>{{ $l }}</h3><p>{{ $data[$k] }}</p></div>@endif
    @endforeach
</div>

{{-- ══════════════ PAGE 7: DEMAND & MARKETING ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📣</div></div>
        <div class="page-header-text"><h2>Marketing Prospects & Competitor Analysis</h2></div>
        <div class="page-num">Page 7</div>
    </div>
    @foreach(['marketing_arrangements'=>'Marketing Arrangements','distribution_strategy'=>'Distribution Strategy','selling_price_analysis'=>'Pricing Analysis (Local vs Import vs Competitors)'] as $k=>$l)
    @if(!empty($data[$k]))<div class="highlight"><h3>{{ $l }}</h3><p>{{ $data[$k] }}</p></div>@endif
    @endforeach
    @if(count($comps)>0)
    <div class="sub-title">Competitor Comparison Table</div>
    <table class="data-table">
        <thead><tr><th>Competitor</th><th>Pricing</th><th>Strengths</th><th>Weaknesses</th><th>Threat</th></tr></thead>
        <tbody>
        <tr style="background:#eff6ff;"><td><strong style="color:{{ $p }};">★ {{ $data['company_name'] }}</strong></td><td style="color:#10b981;font-weight:700;">{{ !empty($data['price_per_unit'])?fmtN($data['price_per_unit']):'—' }}</td><td>{{ substr($data['value_proposition']??'',0,50) }}</td><td style="color:#94a3b8;">N/A</td><td><span class="badge" style="background:#dbeafe;color:#1d4ed8;">Our Co.</span></td></tr>
        @foreach($comps as $c)
        @php $tl = strtolower($c['threat']??''); $bc = str_contains($tl,'low')?'badge-low':(str_contains($tl,'high')?'badge-high':'badge-medium'); @endphp
        <tr><td style="font-weight:700;">{{ $c['name']??'' }}</td><td>{{ $c['pricing']??'' }}</td><td>{{ $c['strengths']??'' }}</td><td>{{ $c['weaknesses']??'' }}</td><td><span class="badge {{ $bc }}">{{ $c['threat']??'' }}</span></td></tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- ══════════════ PAGE 8: OPERATIONS ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">⚙️</div></div>
        <div class="page-header-text"><h2>Operations — Raw Materials & Machinery</h2></div>
        <div class="page-num">Page 8</div>
    </div>
    @if(count($rawMat)>0)
    <div class="sub-title">Sources of Raw Materials</div>
    <table class="data-table">
        <thead><tr><th>Material</th><th>Supplier</th><th>Location</th><th>Unit Cost (₦)</th><th>Availability</th></tr></thead>
        <tbody>
        @foreach($rawMat as $rm)<tr><td style="font-weight:700;">{{ $rm['material']??'' }}</td><td>{{ $rm['supplier']??'' }}</td><td>{{ $rm['location']??'' }}</td><td>{{ !empty($rm['unit_cost'])?fmtN($rm['unit_cost']):'—' }}</td><td><span class="badge badge-neutral">{{ $rm['availability']??'' }}</span></td></tr>@endforeach
        </tbody>
    </table>
    @endif
    @if(count($machs)>0)
    <div class="sub-title">List of Machineries / Equipment</div>
    @php $totalMach = array_sum(array_map(fn($m)=>(float)($m['unit_cost']??0)*(float)($m['quantity']??1),$machs)); @endphp
    <table class="data-table">
        <thead><tr><th>Item</th><th>Qty</th><th>Unit Cost (₦)</th><th>Total Cost (₦)</th><th>Supplier</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($machs as $m)
        @php $mt = (float)($m['unit_cost']??0)*(float)($m['quantity']??1); @endphp
        <tr><td style="font-weight:700;">{{ $m['name']??'' }}</td><td>{{ $m['quantity']??'' }}</td><td>{{ !empty($m['unit_cost'])?fmtN($m['unit_cost']):'—' }}</td><td style="font-weight:700;color:{{ $p }};">{{ fmtN($mt) }}</td><td>{{ $m['supplier']??'' }}</td><td><span class="badge badge-neutral">{{ $m['status']??'' }}</span></td></tr>
        @endforeach
        <tr class="total"><td colspan="3" style="text-align:right;">Total Machinery Cost:</td><td style="color:{{ $p }};">{{ fmtN($totalMach) }}</td><td colspan="2"></td></tr>
        </tbody>
    </table>
    @endif
    @if(count($liabs)>0)
    <div class="sub-title">Outstanding Liabilities</div>
    <table class="data-table">
        <thead><tr><th>Creditor</th><th>Nature</th><th>Amount (₦)</th><th>Due Date</th></tr></thead>
        <tbody>
        @foreach($liabs as $l)<tr><td style="font-weight:700;">{{ $l['creditor']??'' }}</td><td>{{ $l['nature']??'' }}</td><td style="font-weight:700;color:#ef4444;">{{ !empty($l['amount'])?fmtN($l['amount']):'—' }}</td><td>{{ $l['due_date']??'' }}</td></tr>@endforeach
        <tr class="total"><td colspan="2" style="text-align:right;">Total Outstanding:</td><td style="color:#ef4444;">{{ fmtN(array_sum(array_column($liabs,'amount'))) }}</td><td></td></tr>
        </tbody>
    </table>
    @endif
</div>

{{-- ══════════════ PAGE 9: PROJECT COST & MANPOWER ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">🏗️</div></div>
        <div class="page-header-text"><h2>Project Cost & Manpower Plan</h2></div>
        <div class="page-num">Page 9</div>
    </div>
    @if(count($projC)>0)
    @php $totalProjCost = array_sum(array_column($projC,'amount')); @endphp
    <div class="sub-title">Detailed Project Cost Breakdown</div>
    <table class="data-table">
        <thead><tr><th>Cost Item</th><th>Description</th><th>Amount (₦)</th><th>Funding Source</th></tr></thead>
        <tbody>
        @foreach($projC as $pc)<tr><td style="font-weight:700;">{{ $pc['item']??'' }}</td><td style="color:#64748b;">{{ $pc['description']??'' }}</td><td style="font-weight:700;color:{{ $p }};">{{ !empty($pc['amount'])?fmtN($pc['amount']):'—' }}</td><td><span class="badge badge-neutral">{{ $pc['funding_source']??'' }}</span></td></tr>@endforeach
        <tr class="total"><td colspan="2" style="text-align:right;">Total Project Cost:</td><td style="color:{{ $p }};font-size:12px;">{{ fmtN($totalProjCost) }}</td><td></td></tr>
        </tbody>
    </table>
    @if(!empty($data['financial_plan_narrative']))<div class="highlight" style="margin-top:10px;"><h3>Financial Plan</h3><p>{{ $data['financial_plan_narrative'] }}</p></div>@endif
    @endif
    @if(count($mpower)>0)
    @php $totalStaff = array_sum(array_column($mpower,'count')); $totalPayroll = array_sum(array_map(fn($m)=>(float)($m['count']??0)*(float)($m['salary']??0)*12,$mpower)); @endphp
    <div class="sub-title">Comprehensive Manpower Plan</div>
    <table class="data-table">
        <thead><tr><th>Category</th><th>No. of Staff</th><th>Monthly Salary (₦)</th><th>Annual Cost (₦)</th><th>Qualification Required</th></tr></thead>
        <tbody>
        @foreach($mpower as $mp)
        @php $ac = (float)($mp['count']??0)*(float)($mp['salary']??0)*12; @endphp
        <tr><td style="font-weight:700;">{{ $mp['category']??'' }}</td><td style="text-align:center;">{{ $mp['count']??'' }}</td><td>{{ !empty($mp['salary'])?fmtN($mp['salary']):'—' }}</td><td style="font-weight:700;color:{{ $p }};">{{ fmtN($ac) }}</td><td style="color:#64748b;">{{ $mp['qualification']??'' }}</td></tr>
        @endforeach
        <tr class="total"><td><strong>TOTAL</strong></td><td style="text-align:center;"><strong>{{ $totalStaff }}</strong></td><td></td><td style="color:{{ $p }};font-size:12px;"><strong>{{ fmtN($totalPayroll) }}</strong></td><td></td></tr>
        </tbody>
    </table>
    @endif
</div>

{{-- ══════════════ PAGE 10: YEAR 1 FINANCIAL PROJECTIONS ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📈</div></div>
        <div class="page-header-text"><h2>Year 1 Financial Projections</h2></div>
        <div class="page-num">Page 10</div>
    </div>
    <div class="card-row">
        <div class="card-cell"><div class="card"><div class="card-title">Startup Costs</div><div class="card-value" style="color:{{ $p }};font-size:14px;">{{ fmtN($data['startup_costs']??0) }}</div></div></div>
        <div class="card-cell"><div class="card"><div class="card-title">Breakeven (Units/Mo)</div><div class="card-value" style="color:#f59e0b;font-size:14px;">{{ number_format($beU) }}</div></div></div>
        <div class="card-cell"><div class="card"><div class="card-title">Breakeven Revenue</div><div class="card-value" style="color:#10b981;font-size:14px;">{{ fmtN($beR) }}</div></div></div>
        <div class="card-cell"><div class="card"><div class="card-title">Contribution Margin</div><div class="card-value" style="color:#8b5cf6;font-size:14px;">{{ fmtN($price-$varC) }}</div></div></div>
    </div>

    {{-- Revenue bar chart (static HTML) --}}
    <div class="sub-title" style="margin-top:14px;">Monthly Revenue — Year 1</div>
    <div style="margin-bottom:14px;">
        @foreach($revs as $r)
        @php $rv = (float)($r['revenue']??0); $pct = $maxRev>0 ? round($rv/$maxRev*100) : 0; @endphp
        <div style="display:table;width:100%;margin-bottom:3px;">
            <div style="display:table-cell;width:32px;font-size:8px;color:#64748b;vertical-align:middle;">{{ $r['label']??'' }}</div>
            <div style="display:table-cell;vertical-align:middle;"><div class="bar-track"><div class="bar-fill" style="width:{{ $pct }}%;background:{{ $p }};"></div></div></div>
            <div style="display:table-cell;width:60px;text-align:right;font-size:8px;color:#0f172a;font-weight:600;vertical-align:middle;">{{ fmtN($rv) }}</div>
        </div>
        @endforeach
    </div>

    {{-- Expense breakdown --}}
    @if(count($exps)>0)
    <div class="sub-title">Monthly Expense Breakdown</div>
    <table class="data-table">
        <thead><tr><th>Category</th><th style="text-align:right;">Amount (₦)</th><th style="text-align:right;">%</th></tr></thead>
        <tbody>
        @foreach($exps as $e)
        @if(!empty($e['category']) && (float)($e['amount']??0)>0)
        @php $pct = round((float)$e['amount']/$totalExp*100,1); @endphp
        <tr><td>{{ $e['category'] }}</td><td style="text-align:right;font-weight:600;">{{ fmtN($e['amount']) }}</td><td style="text-align:right;color:#64748b;">{{ $pct }}%</td></tr>
        @endif
        @endforeach
        <tr class="total"><td>Total Monthly Expenses</td><td style="text-align:right;color:{{ $p }};">{{ fmtN($totalExp) }}</td><td></td></tr>
        </tbody>
    </table>
    @endif
</div>

{{-- ══════════════ PAGE 11: CASHFLOW ══════════════ --}}
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">💹</div></div>
        <div class="page-header-text"><h2>Cash Flow Analysis — Year 1</h2></div>
        <div class="page-num">Page 11</div>
    </div>
    <table class="data-table">
        <thead><tr><th>Month</th><th style="text-align:right;">Inflow (₦)</th><th style="text-align:right;">Outflow (₦)</th><th style="text-align:right;">Net (₦)</th></tr></thead>
        <tbody>
        @php $totIn=0;$totOut=0; @endphp
        @foreach($cfs as $cf)
        @php $in=(float)($cf['inflow']??0);$out=(float)($cf['outflow']??0);$net=$in-$out;$totIn+=$in;$totOut+=$out; @endphp
        <tr>
            <td style="font-weight:600;">{{ $cf['label']??'' }}</td>
            <td style="text-align:right;color:#10b981;">{{ fmtN($in) }}</td>
            <td style="text-align:right;color:#ef4444;">{{ fmtN($out) }}</td>
            <td style="text-align:right;font-weight:700;color:{{ $net>=0?'#10b981':'#ef4444' }};">{{ fmtN($net) }}</td>
        </tr>
        @endforeach
        @php $totNet=$totIn-$totOut; @endphp
        <tr class="total">
            <td><strong>TOTAL</strong></td>
            <td style="text-align:right;color:#10b981;"><strong>{{ fmtN($totIn) }}</strong></td>
            <td style="text-align:right;color:#ef4444;"><strong>{{ fmtN($totOut) }}</strong></td>
            <td style="text-align:right;font-weight:700;color:{{ $totNet>=0?'#10b981':'#ef4444' }};"><strong>{{ fmtN($totNet) }}</strong></td>
        </tr>
        </tbody>
    </table>
</div>

{{-- ══════════════ PAGE 12: 5-YEAR P&L ══════════════ --}}
@if(!empty($fy['pl']))
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">📊</div></div>
        <div class="page-header-text"><h2>5-Year Profit & Loss Account</h2></div>
        <div class="page-num">Page 12</div>
    </div>
    {{-- 5-yr revenue bars --}}
    @php $maxFyRev = max(array_merge([1], array_map('floatval', $fy['pl']['revenue']??[]))); @endphp
    <div class="sub-title">Revenue Trend — 5 Years</div>
    <div style="margin-bottom:14px;">
        @foreach(($fy['pl']['revenue']??[]) as $yi=>$rv)
        @php $rv=(float)$rv; $pct=$maxFyRev>0?round($rv/$maxFyRev*100):0; @endphp
        <div style="display:table;width:100%;margin-bottom:3px;">
            <div style="display:table-cell;width:45px;font-size:9px;color:#64748b;vertical-align:middle;">Year {{ $yi+1 }}</div>
            <div style="display:table-cell;vertical-align:middle;"><div class="bar-track"><div class="bar-fill" style="width:{{ $pct }}%;background:{{ $p }};"></div></div></div>
            <div style="display:table-cell;width:70px;text-align:right;font-size:9px;color:#0f172a;font-weight:600;vertical-align:middle;">{{ fmtN($rv) }}</div>
        </div>
        @endforeach
    </div>
    <table class="fy-table">
        <thead><tr><th>Item</th><th>Year 1</th><th>Year 2</th><th>Year 3</th><th>Year 4</th><th>Year 5</th></tr></thead>
        <tbody>
        @foreach(['revenue'=>'Revenue / Turnover','cogs'=>'Cost of Goods Sold','gross_profit'=>'Gross Profit','operating_expenses'=>'Operating Expenses','ebitda'=>'EBITDA','depreciation'=>'Depreciation','interest'=>'Interest Expense','ebt'=>'Profit Before Tax','tax'=>'Tax','net_profit'=>'Net Profit After Tax'] as $k=>$l)
        @php $hl = in_array($k,['gross_profit','ebitda','net_profit']); @endphp
        <tr class="{{ $hl?'hl':'' }}">
            <td>{{ $l }}</td>
            @for($y=0;$y<5;$y++)<td>{{ fmtN($fy['pl'][$k][$y]??0) }}</td>@endfor
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- ══════════════ PAGE 13: 5-YEAR CASHFLOW & BALANCE SHEET ══════════════ --}}
@if(!empty($fy['cf']) || !empty($fy['bs']))
<div class="section page-break">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">🏦</div></div>
        <div class="page-header-text"><h2>5-Year Cashflow & Balance Sheet</h2></div>
        <div class="page-num">Page 13</div>
    </div>
    @if(!empty($fy['cf']))
    <div class="sub-title">Cash Flow Statement</div>
    <table class="fy-table" style="margin-bottom:16px;">
        <thead><tr><th>Item</th><th>Year 1</th><th>Year 2</th><th>Year 3</th><th>Year 4</th><th>Year 5</th></tr></thead>
        <tbody>
        @foreach(['operating_cashflow'=>'Operating Cash Flow','investing_cashflow'=>'Investing Cash Flow','financing_cashflow'=>'Financing Cash Flow','net_cashflow'=>'Net Cash Flow','opening_balance'=>'Opening Balance','closing_balance'=>'Closing Balance'] as $k=>$l)
        @php $hl = in_array($k,['net_cashflow','closing_balance']); @endphp
        <tr class="{{ $hl?'hl':'' }}"><td>{{ $l }}</td>@for($y=0;$y<5;$y++)<td>{{ fmtN($fy['cf'][$k][$y]??0) }}</td>@endfor</tr>
        @endforeach
        </tbody>
    </table>
    @endif
    @if(!empty($fy['bs']))
    <div class="sub-title">Balance Sheet</div>
    <table class="fy-table">
        <thead><tr><th>Item</th><th>Year 1</th><th>Year 2</th><th>Year 3</th><th>Year 4</th><th>Year 5</th></tr></thead>
        <tbody>
        <tr class="section-hd"><td colspan="6">Assets</td></tr>
        @foreach(['fixed_assets'=>'Fixed Assets','current_assets'=>'Current Assets','total_assets'=>'Total Assets'] as $k=>$l)
        @php $hl = $k==='total_assets'; @endphp
        <tr class="{{ $hl?'hl':'' }}"><td>{{ $l }}</td>@for($y=0;$y<5;$y++)<td>{{ fmtN($fy['bs'][$k][$y]??0) }}</td>@endfor</tr>
        @endforeach
        <tr class="section-hd"><td colspan="6">Liabilities & Equity</td></tr>
        @foreach(['current_liabilities'=>'Current Liabilities','long_term_liabilities'=>'Long-Term Liabilities','equity'=>'Shareholders Equity','total_liabilities_equity'=>'Total Liabilities & Equity'] as $k=>$l)
        @php $hl = $k==='total_liabilities_equity'; @endphp
        <tr class="{{ $hl?'hl':'' }}"><td>{{ $l }}</td>@for($y=0;$y<5;$y++)<td>{{ fmtN($fy['bs'][$k][$y]??0) }}</td>@endfor</tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endif

{{-- ══════════════ PAGE 14: TEAM & ROADMAP ══════════════ --}}
<div class="section">
    <div class="page-header">
        <div class="page-header-icon"><div class="icon-box">👥</div></div>
        <div class="page-header-text"><h2>Team & Roadmap</h2></div>
        <div class="page-num">Page 14</div>
    </div>
    @if(count($team)>0)
    <div class="sub-title">Core Team</div>
    <div style="display:table;width:100%;margin-bottom:18px;">
        @foreach(array_slice($team,0,3) as $m)
        <div class="team-card">
            <div class="team-avatar">{{ strtoupper(substr($m['name']??'T',0,1)) }}</div>
            <div class="team-name">{{ $m['name']??'' }}</div>
            <div class="team-role">{{ $m['role']??'' }}</div>
            @if(!empty($m['bio']))<div class="team-bio">{{ substr($m['bio'],0,120) }}</div>@endif
        </div>
        @endforeach
    </div>
    @if(count($team)>3)
    <div style="display:table;width:100%;margin-bottom:18px;">
        @foreach(array_slice($team,3,3) as $m)
        <div class="team-card">
            <div class="team-avatar">{{ strtoupper(substr($m['name']??'T',0,1)) }}</div>
            <div class="team-name">{{ $m['name']??'' }}</div>
            <div class="team-role">{{ $m['role']??'' }}</div>
            @if(!empty($m['bio']))<div class="team-bio">{{ substr($m['bio'],0,120) }}</div>@endif
        </div>
        @endforeach
    </div>
    @endif
    @endif
    @if(count($miles)>0)
    <div class="sub-title">Growth Roadmap & Milestones</div>
    <div style="padding-left:8px;">
        @foreach($miles as $ms)
        <div class="timeline-item no-break">
            <div class="t-date">{{ $ms['date']??'' }}</div>
            <div class="t-title">{{ $ms['title']??'' }}</div>
            @if(!empty($ms['description']))<div class="t-desc">{{ $ms['description'] }}</div>@endif
        </div>
        @endforeach
    </div>
    @endif
</div>

</body>
</html>
