<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Plan</title>
    <style>
        @page { margin: 22px 22px; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11.5px;
            color: #111827;
            line-height: 1.35;
        }

        /* Header */
        .header {
            padding: 16px;
            border-radius: 14px;
            background: #0b1220;
            color: #ffffff;
            margin-bottom: 14px;
        }
        .brand-row {
            display: table;
            width: 100%;
        }
        .brand-left, .brand-right {
            display: table-cell;
            vertical-align: middle;
        }
        .brand-right { text-align: right; }
        .logo {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            object-fit: cover;
            background: rgba(255,255,255,0.08);
        }
        .title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 4px 0;
        }
        .subtitle {
            margin: 0;
            opacity: 0.85;
        }
        .pill {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            font-size: 10px;
            margin-top: 10px;
        }

        /* Sections */
        .section {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
        }
        .section h2 {
            margin: 0 0 10px 0;
            font-size: 13px;
            letter-spacing: 0.2px;
        }

        /* Grid helpers (dompdf-friendly) */
        .grid-2 {
            width: 100%;
            display: table;
            table-layout: fixed;
        }
        .col {
            display: table-cell;
            vertical-align: top;
            padding-right: 10px;
        }
        .col:last-child { padding-right: 0; }

        /* KPI cards */
        .kpi-row { display: table; width: 100%; table-layout: fixed; }
        .kpi {
            display: table-cell;
            padding: 10px;
            border-radius: 12px;
            background: #f9fafb;
            border: 1px solid #eef2f7;
            vertical-align: top;
        }
        .kpi-label { font-size: 10px; color: #6b7280; margin-bottom: 4px; }
        .kpi-value { font-size: 14px; font-weight: 800; }

        .muted { color: #6b7280; }
        .bullets { margin: 0; padding-left: 16px; }
        .bullets li { margin: 4px 0; }

        /* Charts */
        .chart {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #eef2f7;
            background: #ffffff;
            padding: 8px;
        }
        .chart img { width: 100%; height: auto; }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.8px;
        }
        th, td {
            border: 1px solid #eef2f7;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f9fafb;
            font-weight: 700;
        }

        /* Photos */
        .photos img{
            width: 100%;
            max-height: 240px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #eef2f7;
            margin-top: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 10px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $business   = $bp['business'] ?? [];
    $sections   = $bp['sections'] ?? [];
    $financials = $bp['financials'] ?? [];
    $market     = $bp['market'] ?? [];
    $operations = $bp['operations'] ?? [];
    $team       = $bp['team'] ?? [];
    $milestones = $bp['milestones'] ?? [];
    $risks      = $bp['risks'] ?? [];

    $charts = $bp['charts'] ?? [];

    // defaults in case empty
    $businessName = $business['name'] ?? 'Business Plan';
    $tagline = $business['tagline'] ?? 'Pitch-deck style business plan';
@endphp

<div class="header">
    <div class="brand-row">
        <div class="brand-left">
            <p class="title">{{ $businessName }}</p>
            <p class="subtitle">
                {{ $tagline }}
                <span class="muted">— Generated on {{ date('d M Y') }}</span>
            </p>
            <span class="pill">
                Currency: ₦ • Duration: 1 Year (Monthly) • A4 • Continuous Report
            </span>
        </div>
        <div class="brand-right">
            @if(!empty($logoDataUri))
                <img class="logo" src="{{ $logoDataUri }}" alt="Logo">
            @endif
        </div>
    </div>
</div>

{{-- Executive Summary --}}
<div class="section">
    <h2>Executive Summary</h2>
    <div class="grid-2">
        <div class="col">
            <p><strong>Overview:</strong> {{ $sections['executive_summary'] ?? '' }}</p>
            <p class="muted"><strong>Business Model:</strong> {{ $business['business_model'] ?? '' }}</p>
        </div>
        <div class="col">
            <div class="kpi-row">
                <div class="kpi">
                    <div class="kpi-label">Target Customers</div>
                    <div class="kpi-value">{{ $market['target_customers'] ?? '-' }}</div>
                </div>
                <div class="kpi" style="padding-left:10px;">
                    <div class="kpi-label">Primary Market</div>
                    <div class="kpi-value">{{ $market['primary_market'] ?? '-' }}</div>
                </div>
            </div>

            <div style="height:8px;"></div>

            <div class="kpi-row">
                <div class="kpi">
                    <div class="kpi-label">Pricing</div>
                    <div class="kpi-value">{{ $business['pricing'] ?? '-' }}</div>
                </div>
                <div class="kpi" style="padding-left:10px;">
                    <div class="kpi-label">Go-to-Market</div>
                    <div class="kpi-value">{{ $market['go_to_market'] ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Problem & Solution --}}
<div class="section">
    <h2>Problem & Solution</h2>
    <div class="grid-2">
        <div class="col">
            <p><strong>Problem:</strong></p>
            <ul class="bullets">
                @foreach(($sections['problem_points'] ?? []) as $p)
                    <li>{{ $p }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <p><strong>Solution:</strong></p>
            <ul class="bullets">
                @foreach(($sections['solution_points'] ?? []) as $p)
                    <li>{{ $p }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Products & Services --}}
<div class="section">
    <h2>Products & Services</h2>
    <p>{{ $sections['products'] ?? '' }}</p>

    @if(!empty($bp['products_list']))
        <table>
            <thead>
            <tr>
                <th style="width:25%;">Item</th>
                <th>Description</th>
                <th style="width:18%;">Price (₦)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bp['products_list'] as $row)
                <tr>
                    <td>{{ $row['name'] ?? '' }}</td>
                    <td>{{ $row['desc'] ?? '' }}</td>
                    <td>{{ $row['price'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Market Analysis --}}
<div class="section">
    <h2>Market Analysis</h2>
    <div class="grid-2">
        <div class="col">
            <p><strong>Market Summary:</strong> {{ $sections['market_summary'] ?? '' }}</p>

            <p><strong>Marketing Channels:</strong></p>
            <ul class="bullets">
                @foreach(($market['channels'] ?? []) as $ch)
                    <li>{{ $ch }}</li>
                @endforeach
            </ul>

            <p><strong>Competitors (List):</strong></p>
            <ul class="bullets">
                @foreach(($market['competitors'] ?? []) as $c)
                    <li>{{ $c }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col">
            @if(!empty($charts['tamsamsom']))
                <div class="chart">
                    <img src="{{ $charts['tamsamsom'] }}" alt="TAM SAM SOM">
                </div>
            @endif
        </div>
    </div>

    @if(!empty($bp['competitor_table']))
        <div style="height:10px;"></div>
        <table>
            <thead>
            <tr>
                <th>Competitor</th>
                <th>Strength</th>
                <th>Weakness</th>
                <th>Our Edge</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bp['competitor_table'] as $row)
                <tr>
                    <td>{{ $row['name'] ?? '' }}</td>
                    <td>{{ $row['strength'] ?? '' }}</td>
                    <td>{{ $row['weakness'] ?? '' }}</td>
                    <td>{{ $row['edge'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Marketing & Sales Strategy --}}
<div class="section">
    <h2>Marketing & Sales Strategy</h2>
    <div class="grid-2">
        <div class="col">
            <p><strong>Sales Strategy:</strong> {{ $sections['sales_strategy'] ?? '' }}</p>
            <p class="muted">
                <strong>Notes:</strong> (Tip) Add a clear customer acquisition plan, pricing logic, and retention method.
            </p>
        </div>
        <div class="col">
            @if(!empty($charts['marketing_funnel']))
                <div class="chart">
                    <img src="{{ $charts['marketing_funnel'] }}" alt="Marketing Funnel">
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Operations Plan --}}
<div class="section">
    <h2>Operations Plan</h2>
    <p>{{ $sections['operations'] ?? '' }}</p>
    <p class="muted"><strong>Key Resources:</strong> {{ $operations['resources'] ?? '' }}</p>
    <p class="muted"><strong>Suppliers/Partners:</strong> {{ $operations['partners'] ?? '' }}</p>
</div>

{{-- Team & Management --}}
<div class="section">
    <h2>Team & Management</h2>
    <p>{{ $sections['team'] ?? '' }}</p>

    @if(!empty($team['members']))
        <table>
            <thead>
            <tr>
                <th style="width:22%;">Name</th>
                <th style="width:20%;">Role</th>
                <th>Experience</th>
            </tr>
            </thead>
            <tbody>
            @foreach($team['members'] as $m)
                <tr>
                    <td>{{ $m['name'] ?? '' }}</td>
                    <td>{{ $m['role'] ?? '' }}</td>
                    <td>{{ $m['experience'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($charts['org_chart']))
        <div style="height:10px;"></div>
        <div class="chart">
            <img src="{{ $charts['org_chart'] }}" alt="Organization Chart">
        </div>
    @endif
</div>

{{-- Financial Plan --}}
<div class="section">
    <h2>Financial Plan (1 Year, Monthly)</h2>

    <div class="grid-2">
        <div class="col">
            @if(!empty($charts['revenue']))
                <div class="chart">
                    <img src="{{ $charts['revenue'] }}" alt="Revenue Projection">
                </div>
            @endif

            <div style="height:10px;"></div>

            @if(!empty($charts['cashflow']))
                <div class="chart">
                    <img src="{{ $charts['cashflow'] }}" alt="Cashflow">
                </div>
            @endif
        </div>

        <div class="col">
            @if(!empty($charts['expenses']))
                <div class="chart">
                    <img src="{{ $charts['expenses'] }}" alt="Expense Breakdown">
                </div>
            @endif

            <div style="height:10px;"></div>

            @if(!empty($charts['breakeven']))
                <div class="chart">
                    <img src="{{ $charts['breakeven'] }}" alt="Breakeven">
                </div>
            @endif
        </div>
    </div>

    @if(!empty($financials['assumptions']))
        <div style="height:10px;"></div>
        <p><strong>Assumptions:</strong></p>
        <ul class="bullets">
            @foreach($financials['assumptions'] as $a)
                <li>{{ $a }}</li>
            @endforeach
        </ul>
    @endif

    @if(!empty($financials['monthly_table']))
        <div style="height:10px;"></div>
        <table>
            <thead>
            <tr>
                <th style="width:10%;">Month</th>
                <th>Revenue (₦)</th>
                <th>Expenses (₦)</th>
                <th>Net (₦)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($financials['monthly_table'] as $row)
                <tr>
                    <td>{{ $row['month'] ?? '' }}</td>
                    <td>{{ $row['revenue'] ?? '' }}</td>
                    <td>{{ $row['expenses'] ?? '' }}</td>
                    <td>{{ $row['net'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Milestones --}}
<div class="section">
    <h2>Milestones & Roadmap</h2>

    @if(!empty($charts['timeline']))
        <div class="chart">
            <img src="{{ $charts['timeline'] }}" alt="Milestone Timeline">
        </div>
    @endif

    @if(!empty($milestones))
        <div style="height:10px;"></div>
        <table>
            <thead>
            <tr>
                <th style="width:18%;">Month</th>
                <th>Milestone</th>
                <th style="width:22%;">Owner</th>
            </tr>
            </thead>
            <tbody>
            @foreach($milestones as $m)
                <tr>
                    <td>{{ $m['month'] ?? '' }}</td>
                    <td>{{ $m['item'] ?? '' }}</td>
                    <td>{{ $m['owner'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Risks --}}
<div class="section">
    <h2>Risks & Mitigation</h2>
    @if(!empty($risks))
        <table>
            <thead>
            <tr>
                <th>Risk</th>
                <th>Impact</th>
                <th>Mitigation</th>
            </tr>
            </thead>
            <tbody>
            @foreach($risks as $r)
                <tr>
                    <td>{{ $r['risk'] ?? '' }}</td>
                    <td>{{ $r['impact'] ?? '' }}</td>
                    <td>{{ $r['mitigation'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="muted">No risks provided.</p>
    @endif
</div>

{{-- Appendix Photos --}}
@if(!empty($photoDataUris))
    <div class="section photos">
        <h2>Appendix (Photos)</h2>
        @foreach($photoDataUris as $p)
            <img src="{{ $p }}" alt="Photo">
        @endforeach
    </div>
@endif

<div class="footer">
    Generated by Business Plan Generator • {{ $businessName }}
</div>

</body>
</html>
