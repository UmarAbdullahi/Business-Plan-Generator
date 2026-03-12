<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, Arial, sans-serif; color: #1e293b; font-size: 12px; line-height: 1.5; }

@php
    $primary   = $data['primary_color'] ?? '#6366f1';
    $secondary = $data['secondary_color'] ?? '#8b5cf6';
    function formatM($n) {
        if ($n >= 1000000000) return '$'.round($n/1000000000,1).'B';
        if ($n >= 1000000) return '$'.round($n/1000000,1).'M';
        if ($n >= 1000) return '$'.round($n/1000,1).'K';
        return '$'.number_format($n);
    }
    $expenses   = $data['monthly_expenses'] ?? [];
    $revenues   = $data['revenue_projections'] ?? [];
    $cashflows  = $data['cashflow_data'] ?? [];
    $competitors = $data['competitors'] ?? [];
    $teamMembers = $data['team_members'] ?? [];
    $milestones  = $data['milestones'] ?? [];
    $tam = (float)($data['tam'] ?? 0);
    $sam = (float)($data['sam'] ?? 0);
    $som = (float)($data['som'] ?? 0);
    $price = (float)($data['price_per_unit'] ?? 1);
    $varCost = (float)($data['variable_cost_per_unit'] ?? 0);
    $fixedCost = (float)($data['fixed_costs_monthly'] ?? 0);
    $cm = $price - $varCost;
    $breakEvenUnits = $cm > 0 ? ceil($fixedCost / $cm) : 0;
    $breakEvenRev = $breakEvenUnits * $price;
    $maxRevenue = max(array_map(fn($r) => (float)($r['revenue'] ?? 0), $revenues) ?: [1]);
    $totalExpenses = array_sum(array_map(fn($e) => (float)($e['amount'] ?? 0), $expenses));
@endphp

.page {
    width: 210mm;
    min-height: 297mm;
    padding: 18mm 16mm 22mm;
    position: relative;
    page-break-after: always;
}

/* Cover */
.cover { background: #0f172a; color: white; }
.cover-accent { background: {{ $primary }}; height: 5px; width: 100%; position: absolute; top: 0; left: 0; }
.cover-bottom { background: {{ $primary }}; height: 5px; width: 100%; position: absolute; bottom: 0; left: 0; }

h1.cover-title { font-size: 38px; font-weight: 900; color: white; line-height: 1.1; margin: 16px 0; }
.cover-tag { font-size: 10px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: {{ $primary }}; margin-bottom: 8px; }
.cover-tagline { font-size: 16px; color: rgba(255,255,255,0.55); font-weight: 300; margin: 0 0 30px; }

.cover-pill {
    display: inline-block;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    color: rgba(255,255,255,0.75);
    margin-right: 6px;
    margin-bottom: 6px;
}

.cover-metric { display: inline-block; margin-right: 30px; }
.cover-metric-value { font-size: 24px; font-weight: 800; color: {{ $primary }}; }
.cover-metric-label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.4); }

/* Section Pages */
.section-header {
    border-bottom: 2px solid {{ $primary }};
    padding-bottom: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-icon {
    background: {{ $primary }};
    color: white;
    width: 28px; height: 28px;
    border-radius: 7px;
    text-align: center;
    line-height: 28px;
    font-size: 13px;
}
.section-title { font-size: 18px; font-weight: 800; color: #0f172a; }

.highlight {
    border-left: 4px solid {{ $primary }};
    padding: 10px 14px;
    background: #f8fafc;
    border-radius: 0 8px 8px 0;
    margin-bottom: 12px;
}
.highlight-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; margin-bottom: 4px; }
.highlight-text { font-size: 11.5px; color: #334155; line-height: 1.6; }

/* Stats Grid */
.stats-row { width: 100%; margin-bottom: 16px; }
.stat-cell {
    display: inline-block;
    width: 30%;
    margin-right: 3%;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
    vertical-align: top;
}
.stat-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; margin-bottom: 4px; }
.stat-value { font-size: 18px; font-weight: 800; color: #0f172a; }

/* Bar Chart */
.chart-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; margin-bottom: 10px; }
.bar-chart { width: 100%; margin-bottom: 20px; }
.bar-row { margin-bottom: 5px; display: flex; align-items: center; gap: 6px; }
.bar-label { font-size: 9px; color: #64748b; width: 22px; text-align: right; flex-shrink: 0; }
.bar-track { flex: 1; background: #f1f5f9; border-radius: 4px; height: 18px; position: relative; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 4px; }
.bar-value { font-size: 9px; color: #64748b; width: 50px; flex-shrink: 0; }

/* Pie Chart (static table) */
.pie-legend { width: 100%; }
.pie-legend td { padding: 5px 8px; font-size: 11px; border-bottom: 1px solid #f1f5f9; }
.pie-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 6px; }

/* Market Circles */
.market-circles { text-align: center; padding: 14px 0; }
.market-circle-wrap { display: inline-block; text-align: center; margin: 0 10px; vertical-align: middle; }
.market-circle { border-radius: 50%; display: inline-block; }

/* Competitor Table */
table.comp { width: 100%; border-collapse: collapse; font-size: 10.5px; }
table.comp th { background: #f1f5f9; padding: 7px 10px; text-align: left; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #64748b; }
table.comp td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
.badge { padding: 2px 8px; border-radius: 999px; font-size: 9px; font-weight: 700; }
.badge-low { background: #dcfce7; color: #166534; }
.badge-medium { background: #fef9c3; color: #854d0e; }
.badge-high { background: #fee2e2; color: #991b1b; }
.badge-us { background: #dbeafe; color: #1d4ed8; }

/* Team Cards */
.team-grid { width: 100%; }
.team-card { display: inline-block; width: 30%; margin-right: 3%; vertical-align: top; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; text-align: center; margin-bottom: 10px; }
.team-avatar { width: 44px; height: 44px; border-radius: 50%; background: {{ $primary }}; color: white; font-size: 18px; font-weight: 800; text-align: center; line-height: 44px; margin: 0 auto 8px; }
.team-name { font-size: 12px; font-weight: 700; color: #0f172a; }
.team-role { font-size: 10px; color: #64748b; }
.team-bio { font-size: 9.5px; color: #94a3b8; margin-top: 4px; line-height: 1.5; }

/* Timeline */
.timeline { padding-left: 20px; position: relative; }
.timeline-item { position: relative; margin-bottom: 18px; padding-left: 16px; }
.timeline-item::before {
    content: '';
    position: absolute;
    left: -18px; top: 5px;
    width: 10px; height: 10px;
    border-radius: 50%;
    background: {{ $primary }};
    border: 2px solid white;
    box-shadow: 0 0 0 2px {{ $primary }};
}
.timeline-item::after {
    content: '';
    position: absolute;
    left: -14px; top: 16px;
    width: 2px; height: calc(100% + 8px);
    background: #e2e8f0;
}
.timeline-item:last-child::after { display: none; }
.timeline-date { font-size: 9px; font-weight: 700; text-transform: uppercase; color: {{ $primary }}; letter-spacing: 0.08em; }
.timeline-title { font-size: 12px; font-weight: 700; color: #0f172a; margin: 2px 0; }
.timeline-desc { font-size: 10.5px; color: #64748b; line-height: 1.5; }

.page-footer { position: absolute; bottom: 10mm; right: 16mm; font-size: 9px; color: #cbd5e1; }
.page-logo { position: absolute; bottom: 10mm; left: 16mm; }

@php
    $colors = [$primary, $secondary, '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6'];
@endphp
</style>
</head>
<body>

{{-- ============================
     PAGE 1: COVER
     ============================ --}}
<div class="page cover">
    <div class="cover-accent"></div>

    @if(!empty($data['logo_base64']))
    <img src="{{ $data['logo_base64'] }}" style="height:55px;object-fit:contain;margin-bottom:30px;border-radius:8px;">
    @endif

    <div class="cover-tag">Business Plan</div>
    <h1 class="cover-title">{{ $data['company_name'] }}</h1>

    @if(!empty($data['tagline']))
    <p class="cover-tagline">{{ $data['tagline'] }}</p>
    @endif

    <div style="margin-bottom:24px;">
        @if(!empty($data['industry']))<span class="cover-pill">🏢 {{ $data['industry'] }}</span>@endif
        @if(!empty($data['business_stage']))<span class="cover-pill">🚀 {{ $data['business_stage'] }} Stage</span>@endif
        @if(!empty($data['location']))<span class="cover-pill">📍 {{ $data['location'] }}</span>@endif
        @if(!empty($data['business_model']))<span class="cover-pill">💼 {{ $data['business_model'] }}</span>@endif
    </div>

    <div style="margin-bottom:30px;">
        @if($tam > 0)
        <div class="cover-metric">
            <div class="cover-metric-value">{{ formatM($tam) }}</div>
            <div class="cover-metric-label">Market Size (TAM)</div>
        </div>
        @endif
        @if(!empty($data['funding_required']))
        <div class="cover-metric" style="color:{{ $secondary }}">
            <div class="cover-metric-value" style="color:{{ $secondary }}">{{ formatM($data['funding_required']) }}</div>
            <div class="cover-metric-label">Raising</div>
        </div>
        @endif
        @if($breakEvenRev > 0)
        <div class="cover-metric" style="color:#10b981">
            <div class="cover-metric-value" style="color:#10b981">{{ formatM($breakEvenRev) }}</div>
            <div class="cover-metric-label">Breakeven Revenue</div>
        </div>
        @endif
    </div>

    @if(!empty($data['photos_base64']) && count($data['photos_base64']) > 0)
    <div style="margin-top:20px;">
        @foreach(array_slice($data['photos_base64'], 0, 3) as $photo)
        <img src="{{ $photo }}" style="height:80px;width:{{ floor(170 / min(3, count($data['photos_base64']))) }}mm;object-fit:cover;border-radius:8px;margin-right:4px;opacity:0.75;display:inline-block;">
        @endforeach
    </div>
    @endif

    <div style="position:absolute;bottom:20px;left:18mm;font-size:10px;color:rgba(255,255,255,0.3);">Confidential — {{ date('Y') }}</div>
    <div class="cover-bottom"></div>
</div>


{{-- ============================
     PAGE 2: EXECUTIVE SUMMARY
     ============================ --}}
<div class="page">
    <div class="section-header">
        <div class="section-icon">📋</div>
        <div class="section-title">Executive Summary</div>
    </div>

    <div class="highlight">
        <div class="highlight-label">Problem</div>
        <div class="highlight-text">{{ $data['problem_statement'] }}</div>
    </div>
    <div class="highlight">
        <div class="highlight-label">Solution</div>
        <div class="highlight-text">{{ $data['solution'] }}</div>
    </div>
    <div class="highlight">
        <div class="highlight-label">Unique Value Proposition</div>
        <div class="highlight-text">{{ $data['value_proposition'] }}</div>
    </div>
    @if(!empty($data['target_market']))
    <div class="highlight">
        <div class="highlight-label">Target Market</div>
        <div class="highlight-text">{{ $data['target_market'] }}</div>
    </div>
    @endif
    @if(!empty($data['revenue_streams']))
    <div class="highlight">
        <div class="highlight-label">Revenue Streams</div>
        <div class="highlight-text">{{ $data['revenue_streams'] }}</div>
    </div>
    @endif

    <div style="margin-top:16px;">
        <div class="stat-cell">
            <div class="stat-label">Business Model</div>
            <div class="stat-value" style="font-size:14px;">{{ $data['business_model'] ?? 'N/A' }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Funding Required</div>
            <div class="stat-value" style="color:{{ $primary }};">{{ !empty($data['funding_required']) ? formatM($data['funding_required']) : 'Bootstrapped' }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Stage</div>
            <div class="stat-value" style="font-size:14px;">{{ $data['business_stage'] ?? 'Early' }}</div>
        </div>
    </div>

    @if(!empty($data['use_of_funds']))
    <div style="margin-top:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
        <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#94a3b8;margin-bottom:6px;">Use of Funds</div>
        <div style="font-size:11.5px;color:#334155;line-height:1.7;">{{ $data['use_of_funds'] }}</div>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Executive Summary | 2</div>
</div>


{{-- ============================
     PAGE 3: MARKET ANALYSIS
     ============================ --}}
<div class="page">
    <div class="section-header">
        <div class="section-icon">🌍</div>
        <div class="section-title">Market Analysis</div>
    </div>

    {{-- TAM/SAM/SOM --}}
    <div class="chart-title">Market Size — TAM / SAM / SOM</div>
    <div class="market-circles">
        @php
            $circles = [
                ['label' => 'TAM', 'val' => $tam, 'size' => 110, 'color' => $primary, 'sub' => 'Total Addressable'],
                ['label' => 'SAM', 'val' => $sam, 'size' => 80, 'color' => $secondary, 'sub' => 'Serviceable Addressable'],
                ['label' => 'SOM', 'val' => $som, 'size' => 55, 'color' => '#10b981', 'sub' => 'Serviceable Obtainable'],
            ];
        @endphp
        @foreach($circles as $c)
        <div class="market-circle-wrap">
            <div class="market-circle" style="width:{{ $c['size'] }}px;height:{{ $c['size'] }}px;background:{{ $c['color'] }};opacity:0.15;"></div>
        </div>
        @endforeach
    </div>
    {{-- Actual data cards --}}
    <div style="margin:10px 0 20px;">
        @foreach($circles as $c)
        <div class="stat-cell">
            <div class="stat-label" style="color:{{ $c['color'] }};">{{ $c['label'] }}</div>
            <div class="stat-value" style="color:{{ $c['color'] }};font-size:17px;">{{ formatM($c['val']) }}</div>
            <div style="font-size:9px;color:#94a3b8;margin-top:3px;">{{ $c['sub'] }}</div>
        </div>
        @endforeach
    </div>

    @if(!empty($data['market_opportunity']))
    <div class="highlight">
        <div class="highlight-label">Market Opportunity</div>
        <div class="highlight-text">{{ $data['market_opportunity'] }}</div>
    </div>
    @endif

    {{-- Competitor Table --}}
    @if(count($competitors) > 0)
    <div style="margin-top:16px;">
        <div class="chart-title">Competitive Landscape</div>
        <table class="comp">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Pricing</th>
                    <th>Strengths</th>
                    <th>Weaknesses</th>
                    <th>Threat</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background:#f0f4ff;">
                    <td><strong style="color:{{ $primary }};">★ {{ $data['company_name'] }}</strong></td>
                    <td style="color:#10b981;font-weight:700;">{{ !empty($data['price_per_unit']) ? formatM($data['price_per_unit']) : '—' }}</td>
                    <td>{{ $data['value_proposition'] ? substr($data['value_proposition'], 0, 50).'...' : '—' }}</td>
                    <td style="color:#94a3b8;">Early stage</td>
                    <td><span class="badge badge-us">Our Co.</span></td>
                </tr>
                @foreach($competitors as $comp)
                <tr>
                    <td>{{ $comp['name'] ?? '—' }}</td>
                    <td>{{ $comp['pricing'] ?? '—' }}</td>
                    <td>{{ $comp['strengths'] ?? '—' }}</td>
                    <td>{{ $comp['weaknesses'] ?? '—' }}</td>
                    <td>
                        @php
                            $t = $comp['threat'] ?? 'Medium threat';
                            $bc = str_contains($t,'Low') ? 'badge-low' : (str_contains($t,'High') ? 'badge-high' : 'badge-medium');
                        @endphp
                        <span class="badge {{ $bc }}">{{ $t }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Market Analysis | 3</div>
</div>


{{-- ============================
     PAGE 4: REVENUE PROJECTIONS
     ============================ --}}
<div class="page">
    <div class="section-header">
        <div class="section-icon">📈</div>
        <div class="section-title">Financial Projections</div>
    </div>

    <div style="margin-bottom:14px;">
        <div class="stat-cell">
            <div class="stat-label">Startup Costs</div>
            <div class="stat-value" style="color:{{ $primary }};">{{ formatM($data['startup_costs'] ?? 0) }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Breakeven Units/Mo</div>
            <div class="stat-value" style="color:#f59e0b;">{{ number_format($breakEvenUnits) }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Breakeven Revenue</div>
            <div class="stat-value" style="color:#10b981;">{{ formatM($breakEvenRev) }}</div>
        </div>
    </div>

    {{-- Revenue Bar Chart (static) --}}
    <div class="chart-title">Revenue Projection — Year 1 (Monthly)</div>
    <div class="bar-chart">
        @foreach($revenues as $r)
        @php
            $rev = (float)($r['revenue'] ?? 0);
            $pct = $maxRevenue > 0 ? min(100, round($rev / $maxRevenue * 100)) : 0;
        @endphp
        <div class="bar-row">
            <div class="bar-label">{{ $r['label'] ?? '' }}</div>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg, {{ $primary }}, {{ $secondary }});"></div>
            </div>
            <div class="bar-value">{{ formatM($rev) }}</div>
        </div>
        @endforeach
    </div>

    {{-- Expense Breakdown --}}
    @if(count($expenses) > 0 && $totalExpenses > 0)
    <div class="chart-title" style="margin-top:4px;">Expense Breakdown</div>
    <table class="pie-legend" style="border-collapse:collapse;">
        @foreach($expenses as $i => $exp)
        @if(!empty($exp['category']) && (float)($exp['amount'] ?? 0) > 0)
        @php $pct = $totalExpenses > 0 ? round((float)$exp['amount'] / $totalExpenses * 100, 1) : 0; @endphp
        <tr>
            <td style="padding:4px 8px;font-size:11px;border-bottom:1px solid #f1f5f9;">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $colors[$i % count($colors)] }};margin-right:6px;"></span>
                {{ $exp['category'] }}
            </td>
            <td style="padding:4px 8px;font-size:11px;border-bottom:1px solid #f1f5f9;text-align:right;font-weight:700;">{{ formatM($exp['amount']) }}</td>
            <td style="padding:4px 8px;font-size:11px;border-bottom:1px solid #f1f5f9;text-align:right;color:#94a3b8;width:50px;">{{ $pct }}%</td>
            <td style="padding:4px 8px;width:100px;">
                <div style="height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $colors[$i % count($colors)] }};border-radius:4px;"></div>
                </div>
            </td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Financial Projections | 4</div>
</div>


{{-- ============================
     PAGE 5: CASHFLOW & BREAKEVEN
     ============================ --}}
<div class="page">
    <div class="section-header">
        <div class="section-icon">💹</div>
        <div class="section-title">Cashflow & Breakeven Analysis</div>
    </div>

    {{-- Cashflow Table --}}
    <div class="chart-title">Monthly Cashflow — Year 1</div>
    @php
        $maxCash = max(array_map(fn($c) => max((float)($c['inflow']??0), (float)($c['outflow']??0)), $cashflows) ?: [1]);
    @endphp
    <table style="width:100%;border-collapse:collapse;font-size:10.5px;margin-bottom:20px;">
        <thead>
            <tr style="background:#f8fafc;">
                <th style="padding:7px 10px;text-align:left;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Month</th>
                <th style="padding:7px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Inflow</th>
                <th style="padding:7px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Outflow</th>
                <th style="padding:7px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Net</th>
                <th style="padding:7px 10px;width:120px;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Visual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cashflows as $cf)
            @php
                $in = (float)($cf['inflow'] ?? 0);
                $out = (float)($cf['outflow'] ?? 0);
                $net = $in - $out;
                $netColor = $net >= 0 ? '#10b981' : '#ef4444';
                $barPct = $maxCash > 0 ? min(100, round($in/$maxCash*100)) : 0;
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:5px 10px;font-weight:600;color:#64748b;">{{ $cf['label'] ?? '' }}</td>
                <td style="padding:5px 10px;text-align:right;color:#10b981;font-weight:600;">{{ formatM($in) }}</td>
                <td style="padding:5px 10px;text-align:right;color:#ef4444;font-weight:600;">{{ formatM($out) }}</td>
                <td style="padding:5px 10px;text-align:right;font-weight:700;color:{{ $netColor }};">{{ $net >= 0 ? '+' : '' }}{{ formatM($net) }}</td>
                <td style="padding:5px 10px;">
                    <div style="height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ $barPct }}%;background:{{ $netColor }};border-radius:4px;"></div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Breakeven --}}
    <div class="chart-title">Breakeven Analysis</div>
    @php
        $maxBEUnits = max($breakEvenUnits * 2, 100);
        $beSteps = 8;
        $stepSize = (int)ceil($maxBEUnits / $beSteps);
    @endphp
    <table style="width:100%;border-collapse:collapse;font-size:10.5px;margin-bottom:16px;">
        <thead>
            <tr style="background:#f8fafc;">
                <th style="padding:6px 10px;text-align:left;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Units</th>
                <th style="padding:6px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#10b981;font-weight:700;">Total Revenue</th>
                <th style="padding:6px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#ef4444;font-weight:700;">Total Cost</th>
                <th style="padding:6px 10px;text-align:right;font-size:9px;text-transform:uppercase;color:#64748b;font-weight:700;">Profit/(Loss)</th>
            </tr>
        </thead>
        <tbody>
            @for($u = 0; $u <= $maxBEUnits; $u += $stepSize)
            @php
                $rev = $u * $price;
                $cost = $fixedCost + $u * $varCost;
                $profit = $rev - $cost;
                $pc = $profit >= 0 ? '#10b981' : '#ef4444';
                $isBE = ($breakEvenUnits > 0 && abs($u - $breakEvenUnits) <= $stepSize / 2);
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;{{ $isBE ? 'background:#fffbeb;' : '' }}">
                <td style="padding:5px 10px;font-weight:{{ $isBE ? '800' : '500' }};{{ $isBE ? 'color:#f59e0b;' : '' }}">
                    {{ number_format($u) }}{{ $isBE ? ' ← Breakeven' : '' }}
                </td>
                <td style="padding:5px 10px;text-align:right;color:#10b981;">{{ formatM($rev) }}</td>
                <td style="padding:5px 10px;text-align:right;color:#ef4444;">{{ formatM($cost) }}</td>
                <td style="padding:5px 10px;text-align:right;font-weight:700;color:{{ $pc }};">{{ $profit >= 0 ? '+' : '' }}{{ formatM($profit) }}</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <div style="display:inline-block;margin-right:16px;">
        <div class="stat-cell">
            <div class="stat-label">Price Per Unit</div>
            <div class="stat-value" style="font-size:15px;">{{ formatM($price) }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Variable Cost</div>
            <div class="stat-value" style="font-size:15px;">{{ formatM($varCost) }}</div>
        </div>
        <div class="stat-cell">
            <div class="stat-label">Contribution Margin</div>
            <div class="stat-value" style="font-size:15px;color:#10b981;">{{ formatM($cm) }}</div>
        </div>
    </div>

    <div class="page-footer">{{ $data['company_name'] }} — Cashflow & Breakeven | 5</div>
</div>


{{-- ============================
     PAGE 6: TEAM & MILESTONES
     ============================ --}}
<div class="page">
    <div class="section-header">
        <div class="section-icon">👥</div>
        <div class="section-title">Team & Growth Roadmap</div>
    </div>

    @if(count($teamMembers) > 0)
    <div class="chart-title">Core Team</div>
    <div style="margin-bottom:24px;">
        @foreach($teamMembers as $member)
        <div class="team-card">
            <div class="team-avatar">{{ strtoupper(substr($member['name'] ?? 'T', 0, 1)) }}</div>
            <div class="team-name">{{ $member['name'] ?? '' }}</div>
            <div class="team-role">{{ $member['role'] ?? '' }}</div>
            @if(!empty($member['bio']))
            <div class="team-bio">{{ substr($member['bio'], 0, 120) }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    @if(count($milestones) > 0)
    <div class="chart-title">Growth Roadmap & Milestones</div>
    <div class="timeline">
        @foreach($milestones as $ms)
        <div class="timeline-item">
            <div class="timeline-date">{{ $ms['date'] ?? '' }}</div>
            <div class="timeline-title">{{ $ms['title'] ?? '' }}</div>
            @if(!empty($ms['description']))
            <div class="timeline-desc">{{ $ms['description'] }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Team & Roadmap | 6</div>
</div>

</body>
</html>
