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
        :root {
            --primary: {{ $data['primary_color'] ?? '#6366f1' }};
            --secondary: {{ $data['secondary_color'] ?? '#8b5cf6' }};
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; margin: 0; }

        /* ---- A4 Pages ---- */
        .page {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 20px auto;
            box-shadow: 0 4px 30px rgba(0,0,0,0.12);
            position: relative;
            overflow: hidden;
            page-break-after: always;
        }

        /* ---- Cover Page ---- */
        .cover-page {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            color: white;
            position: relative;
        }
        .cover-page::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.08;
        }
        .cover-page::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: var(--secondary);
            opacity: 0.08;
        }

        /* ---- Section Pages ---- */
        .section-page { padding: 50px; }
        .page-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 2px solid;
            border-image: linear-gradient(90deg, var(--primary), var(--secondary)) 1;
        }
        .page-header .section-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        .page-header h2 { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; }

        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 8px;
        }
        .card-value {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

        .highlight-box {
            border-left: 4px solid var(--primary);
            padding: 14px 18px;
            background: #f8fafc;
            border-radius: 0 10px 10px 0;
            margin-bottom: 14px;
        }
        .highlight-box h3 { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px; }
        .highlight-box p { font-size: 14px; color: #334155; margin: 0; line-height: 1.6; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-low { background: #dcfce7; color: #166534; }
        .badge-medium { background: #fef9c3; color: #854d0e; }
        .badge-high { background: #fee2e2; color: #991b1b; }

        /* Competitor Table */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #f1f5f9; padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
        td { padding: 10px 14px; border-bottom: 1px solid #e2e8f0; color: #334155; }
        tr:last-child td { border-bottom: none; }

        /* Milestone Timeline */
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px; top: 8px; bottom: 8px;
            width: 2px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
        }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-dot {
            position: absolute;
            left: -26px; top: 4px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: var(--primary);
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--primary);
        }
        .timeline-date { font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 2px; }
        .timeline-title { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
        .timeline-desc { font-size: 12px; color: #64748b; line-height: 1.5; }

        /* Team Cards */
        .team-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
        }
        .team-avatar {
            width: 56px; height: 56px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            margin: 0 auto 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 800;
        }
        .team-name { font-size: 14px; font-weight: 700; color: #0f172a; }
        .team-role { font-size: 11px; color: #64748b; font-weight: 600; }
        .team-bio { font-size: 11px; color: #94a3b8; margin-top: 6px; line-height: 1.5; }

        /* TAM/SAM/SOM */
        .market-ring {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            padding: 20px;
        }

        /* Page number footer */
        .page-footer {
            position: absolute;
            bottom: 20px; right: 40px;
            font-size: 11px;
            color: #94a3b8;
        }
        .page-logo {
            position: absolute;
            bottom: 20px; left: 40px;
        }

        /* Print bar */
        .print-bar {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: 16px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
        }
        .btn-export {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-edit {
            color: #94a3b8;
            background: transparent;
            border: 1px solid #334155;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        @media print {
            .print-bar { display: none; }
            body { background: white; }
            .page { margin: 0; box-shadow: none; page-break-after: always; }
        }
    </style>
</head>
<body>

@php
    $primary = $data['primary_color'] ?? '#6366f1';
    $secondary = $data['secondary_color'] ?? '#8b5cf6';
    $revenues = $data['revenue_projections'] ?? [];
    $cashflows = $data['cashflow_data'] ?? [];
    $expenses = $data['monthly_expenses'] ?? [];
    $competitors = $data['competitors'] ?? [];
    $teamMembers = $data['team_members'] ?? [];
    $milestones = $data['milestones'] ?? [];
    $tam = (float)($data['tam'] ?? 0);
    $sam = (float)($data['sam'] ?? 0);
    $som = (float)($data['som'] ?? 0);
    $pricePerUnit = (float)($data['price_per_unit'] ?? 1);
    $variableCost = (float)($data['variable_cost_per_unit'] ?? 0);
    $fixedCosts = (float)($data['fixed_costs_monthly'] ?? 0);
    $contributionMargin = $pricePerUnit - $variableCost;
    $breakevenUnits = $contributionMargin > 0 ? ceil($fixedCosts / $contributionMargin) : 0;
    $breakevenRevenue = $breakevenUnits * $pricePerUnit;
    $logoPath = !empty($data['logo_path']) ? asset('storage/' . $data['logo_path']) : null;
    $photoPaths = !empty($data['photo_paths']) ? array_map(fn($p) => asset('storage/'.$p), $data['photo_paths']) : [];

    function formatMoney($n) {
        if ($n >= 1000000000) return '$'.round($n/1000000000, 1).'B';
        if ($n >= 1000000) return '$'.round($n/1000000, 1).'M';
        if ($n >= 1000) return '$'.round($n/1000, 1).'K';
        return '$'.number_format($n);
    }
@endphp

{{-- ============================================================
     PAGE 1: COVER
     ============================================================ --}}
<div class="page cover-page" style="min-height:297mm;">
    <div style="position:relative;z-index:1;">
        @if($logoPath)
        <img src="{{ $logoPath }}" style="height:70px;object-fit:contain;margin-bottom:40px;border-radius:10px;">
        @endif

        <div style="font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:{{ $primary }};margin-bottom:16px;">
            Business Plan
        </div>

        <h1 style="font-size:52px;font-weight:900;line-height:1.1;margin:0 0 16px;letter-spacing:-1px;">
            {{ $data['company_name'] }}
        </h1>

        @if(!empty($data['tagline']))
        <p style="font-size:20px;color:rgba(255,255,255,0.6);margin:0 0 40px;font-weight:300;max-width:500px;">
            {{ $data['tagline'] }}
        </p>
        @endif

        <div style="display:flex;gap:24px;flex-wrap:wrap;margin-bottom:50px;">
            @if(!empty($data['industry']))
            <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);padding:10px 18px;border-radius:999px;font-size:13px;color:rgba(255,255,255,0.8);">
                🏢 {{ $data['industry'] }}
            </div>
            @endif
            @if(!empty($data['business_stage']))
            <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);padding:10px 18px;border-radius:999px;font-size:13px;color:rgba(255,255,255,0.8);">
                🚀 {{ $data['business_stage'] }} Stage
            </div>
            @endif
            @if(!empty($data['location']))
            <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);padding:10px 18px;border-radius:999px;font-size:13px;color:rgba(255,255,255,0.8);">
                📍 {{ $data['location'] }}
            </div>
            @endif
        </div>

        {{-- Key metrics bar --}}
        @if($tam > 0 || !empty($data['funding_required']))
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:500px;">
            @if($tam > 0)
            <div>
                <div style="font-size:22px;font-weight:800;color:{{ $primary }};">{{ formatMoney($tam) }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">TAM</div>
            </div>
            @endif
            @if(!empty($data['funding_required']))
            <div>
                <div style="font-size:22px;font-weight:800;color:{{ $secondary }};">{{ formatMoney($data['funding_required']) }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Raising</div>
            </div>
            @endif
            @if($breakevenRevenue > 0)
            <div>
                <div style="font-size:22px;font-weight:800;color:#10b981;">{{ formatMoney($breakevenRevenue) }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Breakeven</div>
            </div>
            @endif
        </div>
        @endif

        {{-- Photos strip --}}
        @if(count($photoPaths) > 0)
        <div style="display:flex;gap:12px;margin-top:50px;">
            @foreach($photoPaths as $photo)
            <img src="{{ $photo }}" style="height:100px;flex:1;object-fit:cover;border-radius:12px;opacity:0.7;">
            @endforeach
        </div>
        @endif
    </div>

    <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:linear-gradient(90deg, {{ $primary }}, {{ $secondary }});"></div>
    <div class="page-footer" style="color:rgba(255,255,255,0.3);">Confidential — {{ date('Y') }}</div>
</div>


{{-- ============================================================
     PAGE 2: EXECUTIVE SUMMARY
     ============================================================ --}}
<div class="page section-page">
    <div class="page-header">
        <div class="section-icon">📋</div>
        <h2>Executive Summary</h2>
    </div>

    <div class="highlight-box">
        <h3>Problem</h3>
        <p>{{ $data['problem_statement'] }}</p>
    </div>
    <div class="highlight-box">
        <h3>Solution</h3>
        <p>{{ $data['solution'] }}</p>
    </div>
    <div class="highlight-box">
        <h3>Value Proposition</h3>
        <p>{{ $data['value_proposition'] }}</p>
    </div>
    @if(!empty($data['target_market']))
    <div class="highlight-box">
        <h3>Target Market</h3>
        <p>{{ $data['target_market'] }}</p>
    </div>
    @endif
    @if(!empty($data['revenue_streams']))
    <div class="highlight-box">
        <h3>Revenue Streams</h3>
        <p>{{ $data['revenue_streams'] }}</p>
    </div>
    @endif

    <div class="grid-3" style="margin-top:24px;">
        <div class="card">
            <div class="card-title">Business Model</div>
            <div class="card-value" style="font-size:16px;">{{ $data['business_model'] ?? 'N/A' }}</div>
        </div>
        <div class="card">
            <div class="card-title">Funding Required</div>
            <div class="card-value" style="color:{{ $primary }};">
                {{ !empty($data['funding_required']) ? formatMoney($data['funding_required']) : 'Bootstrapped' }}
            </div>
        </div>
        <div class="card">
            <div class="card-title">Stage</div>
            <div class="card-value" style="font-size:16px;">{{ $data['business_stage'] ?? 'Early' }}</div>
        </div>
    </div>

    @if(!empty($data['use_of_funds']))
    <div style="margin-top:16px;">
        <div class="card-title" style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Use of Funds</div>
        <div style="font-size:14px;color:#334155;line-height:1.7;background:#f8fafc;padding:16px;border-radius:10px;border:1px solid #e2e8f0;">{{ $data['use_of_funds'] }}</div>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Executive Summary | 2</div>
</div>


{{-- ============================================================
     PAGE 3: MARKET ANALYSIS (TAM/SAM/SOM + Competitor Table)
     ============================================================ --}}
<div class="page section-page">
    <div class="page-header">
        <div class="section-icon">🌍</div>
        <h2>Market Analysis</h2>
    </div>

    {{-- TAM/SAM/SOM --}}
    <div style="margin-bottom:24px;">
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:16px;">Market Size — TAM / SAM / SOM</div>
        <div id="tamChart"></div>
        <div class="grid-3" style="margin-top:20px;">
            <div class="card" style="text-align:center;border-top:3px solid {{ $primary }};">
                <div class="card-title">TAM</div>
                <div class="card-value" style="color:{{ $primary }};font-size:20px;">{{ formatMoney($tam) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Total Addressable Market</div>
            </div>
            <div class="card" style="text-align:center;border-top:3px solid {{ $secondary }};">
                <div class="card-title">SAM</div>
                <div class="card-value" style="color:{{ $secondary }};font-size:20px;">{{ formatMoney($sam) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Serviceable Addressable Market</div>
            </div>
            <div class="card" style="text-align:center;border-top:3px solid #10b981;">
                <div class="card-title">SOM</div>
                <div class="card-value" style="color:#10b981;font-size:20px;">{{ formatMoney($som) }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Serviceable Obtainable Market</div>
            </div>
        </div>
    </div>

    @if(!empty($data['market_opportunity']))
    <div class="highlight-box" style="margin-bottom:24px;">
        <h3>Market Opportunity</h3>
        <p>{{ $data['market_opportunity'] }}</p>
    </div>
    @endif

    {{-- Competitor Table --}}
    @if(count($competitors) > 0)
    <div>
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Competitive Landscape</div>
        <div style="border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <table>
                <thead>
                    <tr>
                        <th>Competitor</th>
                        <th>Pricing</th>
                        <th>Strengths</th>
                        <th>Weaknesses</th>
                        <th>Threat Level</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Our Company Row --}}
                    <tr style="background:linear-gradient(90deg, rgba(99,102,241,0.06), transparent);">
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span style="background:{{ $primary }};color:white;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:700;">US</span>
                                <span style="font-weight:700;color:#0f172a;">{{ $data['company_name'] }}</span>
                            </div>
                        </td>
                        <td style="color:#10b981;font-weight:600;">{{ !empty($data['price_per_unit']) ? formatMoney($data['price_per_unit']) : '—' }}</td>
                        <td style="color:#0f172a;font-weight:600;">{{ $data['value_proposition'] ? substr($data['value_proposition'], 0, 60).'...' : '—' }}</td>
                        <td style="color:#64748b;">Early stage</td>
                        <td><span class="badge" style="background:#dbeafe;color:#1d4ed8;">Our Company</span></td>
                    </tr>
                    @foreach($competitors as $comp)
                    <tr>
                        <td style="font-weight:600;">{{ $comp['name'] ?? '—' }}</td>
                        <td>{{ $comp['pricing'] ?? '—' }}</td>
                        <td style="color:#64748b;">{{ $comp['strengths'] ?? '—' }}</td>
                        <td style="color:#64748b;">{{ $comp['weaknesses'] ?? '—' }}</td>
                        <td>
                            @php
                                $threat = $comp['threat'] ?? 'Medium threat';
                                $cls = str_contains($threat, 'Low') ? 'badge-low' : (str_contains($threat, 'High') ? 'badge-high' : 'badge-medium');
                            @endphp
                            <span class="badge {{ $cls }}">{{ $threat }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Market Analysis | 3</div>
</div>


{{-- ============================================================
     PAGE 4: FINANCIAL PROJECTIONS — Revenue & Expenses
     ============================================================ --}}
<div class="page section-page">
    <div class="page-header">
        <div class="section-icon">📈</div>
        <h2>Financial Projections</h2>
    </div>

    <div class="grid-3" style="margin-bottom:24px;">
        <div class="card">
            <div class="card-title">Startup Costs</div>
            <div class="card-value" style="color:{{ $primary }};">{{ formatMoney($data['startup_costs'] ?? 0) }}</div>
        </div>
        <div class="card">
            <div class="card-title">Breakeven (Units/Mo)</div>
            <div class="card-value" style="color:#f59e0b;">{{ number_format($breakevenUnits) }}</div>
        </div>
        <div class="card">
            <div class="card-title">Breakeven Revenue</div>
            <div class="card-value" style="color:#10b981;">{{ formatMoney($breakevenRevenue) }}</div>
        </div>
    </div>

    {{-- Revenue Projection Chart --}}
    <div style="margin-bottom:24px;">
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;">Revenue Projection — Year 1</div>
        <div id="revenueChart"></div>
    </div>

    {{-- Expense Pie --}}
    @if(count($expenses) > 0)
    <div class="grid-2">
        <div>
            <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;">Expense Breakdown</div>
            <div id="expensePieChart"></div>
        </div>
        <div>
            <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;">Expense Categories</div>
            <div style="display:flex;flex-direction:column;gap:8px;margin-top:8px;">
                @foreach($expenses as $exp)
                @if(!empty($exp['category']) && $exp['amount'] > 0)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;">
                    <span style="font-size:13px;color:#334155;">{{ $exp['category'] }}</span>
                    <span style="font-size:13px;font-weight:700;color:#0f172a;">{{ formatMoney($exp['amount']) }}</span>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Financial Projections | 4</div>
</div>


{{-- ============================================================
     PAGE 5: CASHFLOW & BREAKEVEN
     ============================================================ --}}
<div class="page section-page">
    <div class="page-header">
        <div class="section-icon">💹</div>
        <h2>Cashflow & Breakeven Analysis</h2>
    </div>

    {{-- Cashflow Chart --}}
    <div style="margin-bottom:30px;">
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;">Monthly Cashflow — Year 1</div>
        <div id="cashflowChart"></div>
    </div>

    {{-- Breakeven Chart --}}
    <div>
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;">Breakeven Analysis</div>
        <div id="breakevenChart"></div>
        <div class="grid-3" style="margin-top:20px;">
            <div class="card">
                <div class="card-title">Price Per Unit</div>
                <div class="card-value" style="font-size:18px;">{{ formatMoney($pricePerUnit) }}</div>
            </div>
            <div class="card">
                <div class="card-title">Variable Cost / Unit</div>
                <div class="card-value" style="font-size:18px;">{{ formatMoney($variableCost) }}</div>
            </div>
            <div class="card">
                <div class="card-title">Contribution Margin</div>
                <div class="card-value" style="font-size:18px;color:#10b981;">{{ formatMoney($contributionMargin) }}</div>
            </div>
        </div>
    </div>

    <div class="page-footer">{{ $data['company_name'] }} — Cashflow & Breakeven | 5</div>
</div>


{{-- ============================================================
     PAGE 6: TEAM & MILESTONES
     ============================================================ --}}
<div class="page section-page">
    <div class="page-header">
        <div class="section-icon">👥</div>
        <h2>Team & Roadmap</h2>
    </div>

    {{-- Team --}}
    @if(count($teamMembers) > 0)
    <div style="margin-bottom:32px;">
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:16px;">Core Team</div>
        <div style="display:grid;grid-template-columns:repeat({{ min(count($teamMembers), 3) }}, 1fr);gap:16px;">
            @foreach($teamMembers as $member)
            <div class="team-card">
                <div class="team-avatar">{{ strtoupper(substr($member['name'] ?? 'T', 0, 1)) }}</div>
                <div class="team-name">{{ $member['name'] ?? 'Team Member' }}</div>
                <div class="team-role">{{ $member['role'] ?? '' }}</div>
                @if(!empty($member['bio']))
                <div class="team-bio">{{ $member['bio'] }}</div>
                @endif
                @if(!empty($member['linkedin']))
                <div style="margin-top:6px;font-size:10px;color:#94a3b8;">🔗 {{ $member['linkedin'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Milestones --}}
    @if(count($milestones) > 0)
    <div>
        <div style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:20px;">Growth Roadmap & Milestones</div>
        <div class="timeline">
            @foreach($milestones as $ms)
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">{{ $ms['date'] ?? '' }}</div>
                <div class="timeline-title">{{ $ms['title'] ?? '' }}</div>
                @if(!empty($ms['description']))
                <div class="timeline-desc">{{ $ms['description'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="page-footer">{{ $data['company_name'] }} — Team & Roadmap | 6</div>
</div>


{{-- ============================================================
     PRINT BAR
     ============================================================ --}}
<div class="print-bar">
    <div style="display:flex;align-items:center;gap:16px;">
        <a href="{{ route('home') }}" style="color:#94a3b8;text-decoration:none;font-size:14px;">← Edit Plan</a>
        <span style="color:#1e293b;">|</span>
        <span style="color:#94a3b8;font-size:14px;">{{ $data['company_name'] }} — Business Plan</span>
    </div>
    <form action="{{ route('export.pdf') }}" method="POST">
        @csrf
        <button type="submit" class="btn-export">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 16l-4-4h3V4h2v8h3l-4 4z"/><path d="M5 20h14"/></svg>
            Export to PDF
        </button>
    </form>
</div>

<div style="height:80px;"></div>{{-- Spacer for print bar --}}


{{-- ============================================================
     APEX CHARTS SCRIPTS
     ============================================================ --}}
<script>
const PRIMARY = '{{ $primary }}';
const SECONDARY = '{{ $secondary }}';
const months = {!! json_encode(array_column($revenues, 'label')) !!};

// ---- Revenue Projection Chart ----
const revenueData = {!! json_encode(array_map(fn($r) => (float)($r['revenue'] ?? 0), $revenues)) !!};
new ApexCharts(document.getElementById('revenueChart'), {
    series: [{ name: 'Revenue', data: revenueData }],
    chart: { type: 'area', height: 200, toolbar: { show: false }, sparkline: { enabled: false } },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 3 },
    fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.0 }
    },
    colors: [PRIMARY],
    xaxis: { categories: months, labels: { style: { fontSize: '11px', colors: '#94a3b8' } } },
    yaxis: { labels: { formatter: v => '$' + (v >= 1000 ? (v/1000).toFixed(0)+'K' : v), style: { fontSize: '11px', colors: '#94a3b8' } } },
    grid: { borderColor: '#f1f5f9' },
    tooltip: { y: { formatter: v => '$' + v.toLocaleString() } }
}).render();

// ---- Expense Pie Chart ----
@if(count($expenses) > 0)
const expCategories = {!! json_encode(array_column($expenses, 'category')) !!};
const expAmounts = {!! json_encode(array_map(fn($e) => (float)($e['amount'] ?? 0), $expenses)) !!};
new ApexCharts(document.getElementById('expensePieChart'), {
    series: expAmounts,
    labels: expCategories,
    chart: { type: 'donut', height: 220, toolbar: { show: false } },
    colors: [PRIMARY, SECONDARY, '#10b981', '#f59e0b', '#ef4444', '#06b6d4'],
    legend: { position: 'bottom', fontSize: '11px' },
    dataLabels: { enabled: true, formatter: (val) => val.toFixed(1) + '%' },
    plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'Total' } } } } },
}).render();
@endif

// ---- Cashflow Chart ----
const cashflowMonths = {!! json_encode(array_column($cashflows, 'label')) !!};
const inflows = {!! json_encode(array_map(fn($c) => (float)($c['inflow'] ?? 0), $cashflows)) !!};
const outflows = {!! json_encode(array_map(fn($c) => (float)($c['outflow'] ?? 0), $cashflows)) !!};
const netCashflow = inflows.map((v, i) => v - outflows[i]);

new ApexCharts(document.getElementById('cashflowChart'), {
    series: [
        { name: 'Inflow', data: inflows },
        { name: 'Outflow', data: outflows },
        { name: 'Net Cashflow', type: 'line', data: netCashflow }
    ],
    chart: { type: 'bar', height: 220, toolbar: { show: false } },
    colors: ['#10b981', '#ef4444', PRIMARY],
    stroke: { width: [0, 0, 3], curve: 'smooth' },
    plotOptions: { bar: { columnWidth: '60%', borderRadius: 4 } },
    dataLabels: { enabled: false },
    xaxis: { categories: cashflowMonths, labels: { style: { fontSize: '11px', colors: '#94a3b8' } } },
    yaxis: { labels: { formatter: v => '$' + (Math.abs(v) >= 1000 ? (v/1000).toFixed(0)+'K' : v), style: { fontSize: '11px', colors: '#94a3b8' } } },
    legend: { position: 'top', fontSize: '12px' },
    grid: { borderColor: '#f1f5f9' },
}).render();

// ---- Breakeven Chart ----
const fixedCosts = {{ $fixedCosts }};
const pricePerUnit = {{ $pricePerUnit }};
const variableCost = {{ $variableCost }};
const maxUnits = {{ max($breakevenUnits * 2, 100) }};
const step = Math.max(1, Math.floor(maxUnits / 10));
const unitRange = Array.from({ length: 12 }, (_, i) => i * step);
const totalCostLine = unitRange.map(u => fixedCosts + variableCost * u);
const totalRevLine   = unitRange.map(u => pricePerUnit * u);

new ApexCharts(document.getElementById('breakevenChart'), {
    series: [
        { name: 'Total Revenue', data: totalRevLine },
        { name: 'Total Costs', data: totalCostLine }
    ],
    chart: { type: 'line', height: 220, toolbar: { show: false } },
    colors: ['#10b981', '#ef4444'],
    stroke: { width: 3, curve: 'straight', dashArray: [0, 6] },
    xaxis: { categories: unitRange.map(u => u + ' units'), labels: { style: { fontSize: '11px', colors: '#94a3b8' } } },
    yaxis: { labels: { formatter: v => '$' + (v >= 1000 ? (v/1000).toFixed(0)+'K' : v), style: { fontSize: '11px', colors: '#94a3b8' } } },
    annotations: {
        xaxis: [{
            x: {{ $breakevenUnits }} + ' units',
            strokeDashArray: 0,
            borderColor: '#f59e0b',
            label: { text: 'Breakeven: {{ number_format($breakevenUnits) }} units', style: { background: '#f59e0b', color: '#fff', fontSize: '11px' } }
        }]
    },
    legend: { position: 'top', fontSize: '12px' },
    grid: { borderColor: '#f1f5f9' },
}).render();

// ---- TAM/SAM/SOM Bubble/Radial Chart ----
const tam = {{ $tam }};
const sam = {{ $sam }};
const som = {{ $som }};
const samPct = tam > 0 ? parseFloat((sam/tam*100).toFixed(1)) : 0;
const somPct = tam > 0 ? parseFloat((som/tam*100).toFixed(1)) : 0;

new ApexCharts(document.getElementById('tamChart'), {
    series: [100, samPct > 0 ? samPct : 10, somPct > 0 ? somPct : 1],
    labels: [
        'TAM — {{ formatMoney($tam) }}',
        'SAM — {{ formatMoney($sam) }}',
        'SOM — {{ formatMoney($som) }}'
    ],
    chart: { type: 'radialBar', height: 220, toolbar: { show: false } },
    colors: [PRIMARY, SECONDARY, '#10b981'],
    plotOptions: {
        radialBar: {
            offsetY: 0,
            startAngle: -135,
            endAngle: 135,
            hollow: { size: '30%' },
            dataLabels: {
                name: { fontSize: '12px', fontFamily: 'Inter', fontWeight: 700 },
                value: { fontSize: '13px', fontFamily: 'Inter', formatter: (val, opts) => {
                    const labels = ['TAM','SAM','SOM'];
                    return labels[opts.seriesIndex] || val + '%';
                }}
            },
            track: { background: '#f1f5f9' }
        }
    },
    legend: { show: true, position: 'bottom', fontSize: '11px' }
}).render();
</script>

</body>
</html>
