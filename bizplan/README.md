# Business Plan Generator — Laravel 11

## Stack
- **Laravel 11** + Blade + Alpine.js
- **ApexCharts** for all charts and infographics
- **DomPDF** for PDF export
- **Tailwind CSS** (CDN) for styling

## Setup

```bash
composer create-project laravel/laravel business-plan-generator
cd business-plan-generator

# Install DomPDF
composer require barryvdh/laravel-dompdf

# Copy all files from this archive into the project
# Then run:
php artisan storage:link
php artisan serve
```

## File Structure

```
app/
  Http/
    Controllers/
      BusinessPlanController.php
resources/
  views/
    layouts/
      app.blade.php
    wizard/
      step1.blade.php   (Company & Branding)
      step2.blade.php   (Business Details)
      step3.blade.php   (Market & Competitors)
      step4.blade.php   (Team & Milestones)
      step5.blade.php   (Financials)
    plan/
      preview.blade.php
      pdf.blade.php
routes/
  web.php
public/
  css/
    plan.css
```

## Features
- 5-step wizard form
- Logo upload + brand color picker
- Business photos upload (optional)
- Revenue projection chart (ApexCharts line)
- Expense breakdown pie chart
- Cashflow chart (bar)
- Breakeven chart (line)
- TAM/SAM/SOM market graphic (donut)
- Milestone timeline
- Competitor comparison table
- Team/org chart
- Export to PDF (A4 pitch deck style)
