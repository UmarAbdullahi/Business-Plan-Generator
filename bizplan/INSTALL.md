# 📊 BizPlan Pro — Business Plan Generator

A professional, pitch-deck style business plan generator built with **Laravel 11 + Blade + Alpine.js + ApexCharts + DomPDF**.

---

## 🚀 Quick Setup

### Prerequisites
- PHP 8.2+
- Composer
- PHP extensions: `gd`, `mbstring`, `xml`, `zip`

### Option A — New Laravel Project (Recommended)

```bash
# 1. Create fresh Laravel 11 project
composer create-project laravel/laravel bizplan-pro
cd bizplan-pro

# 2. Install DomPDF
composer require barryvdh/laravel-dompdf

# 3. Copy ALL files from this package into the project root
#    (overwrite existing files)

# 4. Run setup
chmod +x setup.sh && ./setup.sh

# 5. Start server
php artisan serve
# Open: http://localhost:8000
```

### Option B — Manual Steps

```bash
composer require barryvdh/laravel-dompdf
php artisan key:generate
php artisan storage:link
mkdir -p storage/app/public/uploads/logos
mkdir -p storage/app/public/uploads/photos
mkdir -p storage/fonts
php artisan serve
```

---

## 📁 Files to Copy

Copy these into your Laravel project:

```
app/Http/Controllers/BusinessPlanController.php
config/dompdf.php
resources/views/layouts/app.blade.php
resources/views/wizard/index.blade.php
resources/views/plan/preview.blade.php
resources/views/plan/pdf.blade.php
routes/web.php
```

---

## 📋 Features

### Input Form (5-Step Wizard)
| Step | Content |
|------|---------|
| 1 | Company name, tagline, industry, stage, logo upload, brand colors, business photos |
| 2 | Business model, problem, solution, value proposition, target market, funding |
| 3 | TAM/SAM/SOM market sizes, market opportunity, competitor analysis |
| 4 | Team members, milestone roadmap |
| 5 | Financial data: startup costs, expense breakdown, revenue projections, cashflow |

### Business Plan Output
| Section | Charts/Graphics |
|---------|----------------|
| Cover Page | Company branding, key metrics |
| Executive Summary | Problem/Solution/UVP highlights |
| Market Analysis | TAM/SAM/SOM radial chart, competitor table |
| Financial Projections | Revenue area chart, expense pie chart |
| Cashflow & Breakeven | Cashflow bar+line chart, breakeven line chart |
| Team & Roadmap | Team org cards, milestone timeline |

### PDF Export
- A4 portrait format
- Pitch-deck dark cover, clean section pages
- Static chart representations (bar charts, tables, progress bars)
- Logo and photos embedded as base64
- Breakeven analysis table with highlighted breakeven point

---

## ⚙️ Configuration

Edit `.env` for any environment changes. The app uses file-based sessions by default — no database needed.

```env
APP_NAME="BizPlan Pro"
APP_ENV=local
APP_KEY=  # auto-generated
APP_DEBUG=true
APP_URL=http://localhost:8000

SESSION_DRIVER=file
FILESYSTEM_DISK=local
```

---

## 🔧 Customization

### Change default brand colors
In `resources/views/wizard/index.blade.php`, find:
```javascript
primary_color: '#6366f1',
secondary_color: '#8b5cf6',
```

### Add more form fields
1. Add input to the wizard (`wizard/index.blade.php`)
2. Add to validation in `BusinessPlanController.php`
3. Add display in `plan/preview.blade.php` and `plan/pdf.blade.php`

### Extend PDF styling
Edit `resources/views/plan/pdf.blade.php` — uses inline CSS for DomPDF compatibility.

---

## 📦 Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/framework` | ^11.0 | Framework |
| `barryvdh/laravel-dompdf` | ^3.0 | PDF generation |
| Alpine.js | 3.x (CDN) | Reactive form wizard |
| ApexCharts | Latest (CDN) | Interactive charts |
| Tailwind CSS | Latest (CDN) | Styling |
| Google Fonts (Inter) | CDN | Typography |

---

## 🐞 Troubleshooting

**PDF is blank or broken**
- Ensure `storage/fonts/` directory exists and is writable
- Run `php artisan storage:link`
- Check `enable_remote => true` in `config/dompdf.php`

**Images not showing in PDF**
- Ensure `php artisan storage:link` was run
- Check that `storage/app/public/` is writable

**Session not persisting between form and preview**
- Ensure `SESSION_DRIVER=file` in `.env`
- Run `php artisan config:clear`

**Charts not rendering**
- ApexCharts requires JavaScript — charts only appear in the web preview
- The PDF uses static HTML/CSS chart representations instead
