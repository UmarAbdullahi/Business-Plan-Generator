@extends('layouts.app')
@section('title', 'Business Plan Generator')
@section('content')

<div x-data="bizPlanWizard()" class="min-h-screen">

    {{-- Header --}}
    <div class="px-6 py-8 text-center">
        <div class="inline-flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xl">📊</div>
            <h1 class="text-3xl font-black tracking-tight">BizPlan<span class="text-indigo-400">Pro</span></h1>
        </div>
        <p class="text-white/50 text-sm">Generate a professional business plan</p>
    </div>

    {{-- Progress Steps (scrollable on mobile) --}}
    <div class="max-w-5xl mx-auto px-4 mb-8 overflow-x-auto">
        <div class="flex items-center justify-start md:justify-center gap-1 min-w-max mx-auto px-2">
            @php
            $steps = [
                ['icon'=>'🏢','label'=>'Company'],
                ['icon'=>'💡','label'=>'Business'],
                ['icon'=>'📜','label'=>'History'],
                ['icon'=>'👔','label'=>'Directors'],
                ['icon'=>'📋','label'=>'CVs'],
                ['icon'=>'🌍','label'=>'Market'],
                ['icon'=>'⚙️','label'=>'Operations'],
                ['icon'=>'👥','label'=>'Team'],
                ['icon'=>'🏗️','label'=>'Project'],
                ['icon'=>'💰','label'=>'Yr 1 Finance'],
                ['icon'=>'📈','label'=>'5-Yr Plan'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="flex items-center gap-1">
                <div class="flex flex-col items-center gap-1">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-base transition-all duration-300 font-bold text-xs"
                         :class="currentStep > {{ $i+1 }} ? 'step-done' : (currentStep === {{ $i+1 }} ? 'step-active' : 'step-inactive')">
                        <span x-show="currentStep > {{ $i+1 }}">✓</span>
                        <span x-show="currentStep <= {{ $i+1 }}">{{ $step['icon'] }}</span>
                    </div>
                    <span class="text-xs transition-all whitespace-nowrap" :class="currentStep === {{ $i+1 }} ? 'text-indigo-400 font-semibold' : 'text-white/30'">{{ $step['label'] }}</span>
                </div>
                @if($i < count($steps)-1)
                <div class="w-5 h-px mb-5 transition-all duration-500 flex-shrink-0" :class="currentStep > {{ $i+1 }} ? 'bg-emerald-400' : 'bg-white/10'"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <form action="{{ route('generate') }}" method="POST" enctype="multipart/form-data" id="mainForm">
        @csrf

        {{-- ═══ ALL HIDDEN FIELDS ═══ --}}
        {{-- Scalars --}}
        <input type="hidden" id="h_company_name"              name="company_name">
        <input type="hidden" id="h_tagline"                   name="tagline">
        <input type="hidden" id="h_industry"                  name="industry">
        <input type="hidden" id="h_founded_year"              name="founded_year">
        <input type="hidden" id="h_business_stage"            name="business_stage">
        <input type="hidden" id="h_location"                  name="location">
        <input type="hidden" id="h_primary_color"             name="primary_color">
        <input type="hidden" id="h_secondary_color"           name="secondary_color">
        <input type="hidden" id="h_business_model"            name="business_model">
        <input type="hidden" id="h_problem_statement"         name="problem_statement">
        <input type="hidden" id="h_solution"                  name="solution">
        <input type="hidden" id="h_value_proposition"         name="value_proposition">
        <input type="hidden" id="h_target_market"             name="target_market">
        <input type="hidden" id="h_revenue_streams"           name="revenue_streams">
        <input type="hidden" id="h_funding_required"          name="funding_required">
        <input type="hidden" id="h_use_of_funds"              name="use_of_funds">
        <input type="hidden" id="h_company_history"           name="company_history">
        <input type="hidden" id="h_incorporation_date"        name="incorporation_date">
        <input type="hidden" id="h_rc_number"                 name="rc_number">
        <input type="hidden" id="h_activities_since_inc"      name="activities_since_inc">
        <input type="hidden" id="h_market_opportunity"        name="market_opportunity">
        <input type="hidden" id="h_tam"                       name="tam">
        <input type="hidden" id="h_sam"                       name="sam">
        <input type="hidden" id="h_som"                       name="som">
        <input type="hidden" id="h_supply_analysis"           name="supply_analysis">
        <input type="hidden" id="h_demand_analysis"           name="demand_analysis">
        <input type="hidden" id="h_demand_factors"            name="demand_factors">
        <input type="hidden" id="h_domestic_demand"           name="domestic_demand">
        <input type="hidden" id="h_export_potential"          name="export_potential">
        <input type="hidden" id="h_marketing_arrangements"    name="marketing_arrangements">
        <input type="hidden" id="h_distribution_strategy"     name="distribution_strategy">
        <input type="hidden" id="h_selling_price_analysis"    name="selling_price_analysis">
        <input type="hidden" id="h_project_cost_description"  name="project_cost_description">
        <input type="hidden" id="h_financial_plan_narrative"  name="financial_plan_narrative">
        <input type="hidden" id="h_startup_costs"             name="startup_costs">
        <input type="hidden" id="h_price_per_unit"            name="price_per_unit">
        <input type="hidden" id="h_variable_cost_per_unit"    name="variable_cost_per_unit">
        <input type="hidden" id="h_fixed_costs_monthly"       name="fixed_costs_monthly">
        {{-- JSON arrays --}}
        <input type="hidden" id="h_directors"                 name="directors">
        <input type="hidden" id="h_management_staff"          name="management_staff">
        <input type="hidden" id="h_technical_staff"           name="technical_staff">
        <input type="hidden" id="h_key_cvs"                   name="key_cvs">
        <input type="hidden" id="h_competitors"               name="competitors">
        <input type="hidden" id="h_supply_sources"            name="supply_sources">
        <input type="hidden" id="h_raw_materials"             name="raw_materials">
        <input type="hidden" id="h_machineries"               name="machineries">
        <input type="hidden" id="h_liabilities"               name="liabilities">
        <input type="hidden" id="h_team_members"              name="team_members">
        <input type="hidden" id="h_milestones"                name="milestones">
        <input type="hidden" id="h_manpower"                  name="manpower">
        <input type="hidden" id="h_project_costs"             name="project_costs">
        <input type="hidden" id="h_monthly_expenses"          name="monthly_expenses">
        <input type="hidden" id="h_revenue_projections"       name="revenue_projections">
        <input type="hidden" id="h_cashflow_data"             name="cashflow_data">
        <input type="hidden" id="h_five_year_projections"     name="five_year_projections">

        {{-- File inputs --}}
        <input type="file" id="logoFile"   name="logo"              accept="image/*"         class="hidden" @change="previewLogo($event)">
        <input type="file" id="photosFile" name="business_photos[]" accept="image/*" multiple class="hidden" @change="previewPhotos($event)">

        <div class="max-w-4xl mx-auto px-6 pb-24">

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 1 — COMPANY & BRANDING                        ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">🏢 Company & Branding</h2>
                    <p class="text-white/50 text-sm mb-8">Basic information about your company</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="form-label">Company Name *</label>
                            <input type="text" x-model="form.company_name" class="form-input" placeholder="e.g. Acme Nigeria Ltd">
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Tagline / Slogan</label>
                            <input type="text" x-model="form.tagline" class="form-input" placeholder="e.g. Building the future of Nigeria">
                        </div>
                        <div>
                            <label class="form-label">Industry</label>
                            <select x-model="form.industry" class="form-input">
                                <option value="">Select industry...</option>
                                <option>Technology / SaaS</option><option>E-Commerce / Retail</option>
                                <option>Healthcare</option><option>Fintech</option>
                                <option>Education</option><option>Real Estate</option>
                                <option>Food & Beverage</option><option>Manufacturing</option>
                                <option>Agriculture</option><option>Consulting / Services</option>
                                <option>Media & Entertainment</option><option>Transportation & Logistics</option>
                                <option>Oil & Gas</option><option>Construction</option><option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">RC Number</label>
                            <input type="text" x-model="form.rc_number" class="form-input" placeholder="e.g. RC-1234567">
                        </div>
                        <div>
                            <label class="form-label">Date of Incorporation</label>
                            <input type="date" x-model="form.incorporation_date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Business Stage</label>
                            <select x-model="form.business_stage" class="form-input">
                                <option value="Idea">Idea Stage</option><option value="MVP">MVP / Prototype</option>
                                <option value="Early">Early Revenue</option><option value="Growth">Growth Stage</option>
                                <option value="Scaling">Scaling</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Location / HQ</label>
                            <input type="text" x-model="form.location" class="form-input" placeholder="e.g. Lagos, Nigeria">
                        </div>
                        <div>
                            <label class="form-label">Company Logo</label>
                            <div class="border-2 border-dashed border-white/20 rounded-xl p-4 text-center hover:border-indigo-400 transition-colors cursor-pointer" @click="document.getElementById('logoFile').click()">
                                <template x-if="!logoPreview"><div><div class="text-3xl mb-2">🖼️</div><p class="text-white/50 text-sm">Click to upload logo</p><p class="text-white/30 text-xs">PNG, JPG up to 4MB</p></div></template>
                                <template x-if="logoPreview"><img :src="logoPreview" class="max-h-20 mx-auto rounded-lg object-contain"></template>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Business Photos <span class="text-white/40">(optional, up to 3)</span></label>
                            <div class="border-2 border-dashed border-white/20 rounded-xl p-4 text-center hover:border-indigo-400 transition-colors cursor-pointer" @click="document.getElementById('photosFile').click()">
                                <div x-show="photoPreviews.length === 0"><div class="text-3xl mb-2">📸</div><p class="text-white/50 text-sm">Click to upload photos</p></div>
                                <div x-show="photoPreviews.length > 0" class="flex gap-2 flex-wrap justify-center">
                                    <template x-for="photo in photoPreviews" :key="photo"><img :src="photo" class="h-14 w-14 object-cover rounded-lg"></template>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Primary Brand Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" x-model="form.primary_color" class="cursor-pointer rounded-xl border border-white/20 h-10 w-10">
                                <span class="text-white/60 font-mono text-sm" x-text="form.primary_color"></span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Secondary Brand Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" x-model="form.secondary_color" class="cursor-pointer rounded-xl border border-white/20 h-10 w-10">
                                <span class="text-white/60 font-mono text-sm" x-text="form.secondary_color"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 2 — BUSINESS DETAILS                          ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">💡 Business Details</h2>
                    <p class="text-white/50 text-sm mb-8">Describe your business concept</p>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="form-label">Business Model</label>
                            <select x-model="form.business_model" class="form-input">
                                <option value="">Select model...</option>
                                <option>B2B SaaS</option><option>B2C SaaS</option><option>Marketplace</option>
                                <option>E-Commerce</option><option>Subscription</option><option>Freemium</option>
                                <option>Franchise</option><option>Direct Sales</option>
                                <option>Consulting / Services</option><option>Manufacturing</option><option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Problem Statement</label>
                            <textarea x-model="form.problem_statement" class="form-input" placeholder="What problem does your business solve?"></textarea>
                        </div>
                        <div>
                            <label class="form-label">Your Solution</label>
                            <textarea x-model="form.solution" class="form-input" placeholder="How does your product/service solve the problem?"></textarea>
                        </div>
                        <div>
                            <label class="form-label">Unique Value Proposition</label>
                            <textarea x-model="form.value_proposition" class="form-input" placeholder="What makes your business unique?"></textarea>
                        </div>
                        <div>
                            <label class="form-label">Target Market / Customers</label>
                            <textarea x-model="form.target_market" class="form-input" placeholder="Describe your ideal customers."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Revenue Streams</label>
                            <textarea x-model="form.revenue_streams" class="form-input" placeholder="e.g. Product sales, service fees, licensing..." rows="3"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">Funding Required (₦)</label>
                                <input type="number" x-model="form.funding_required" class="form-input" placeholder="e.g. 50000000">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Use of Funds</label>
                            <textarea x-model="form.use_of_funds" class="form-input" placeholder="e.g. 40% Equipment, 30% Working Capital, 20% Marketing..." rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 3 — COMPANY HISTORY & ACTIVITIES              ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">📜 Company History & Activities</h2>
                    <p class="text-white/50 text-sm mb-8">Background and activities since incorporation</p>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="form-label">Company Background / History</label>
                            <textarea x-model="form.company_history" class="form-input" rows="5"
                                placeholder="Describe the history of the company — how it was founded, key events, ownership structure, etc."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Activities Since Incorporation</label>
                            <textarea x-model="form.activities_since_inc" class="form-input" rows="6"
                                placeholder="Describe in detail what the company has done since incorporation: contracts executed, products launched, partnerships formed, revenue generated, facilities established, certifications obtained, etc."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Nature of Project / Proposed Activities</label>
                            <textarea x-model="form.project_nature" class="form-input" rows="5"
                                placeholder="Describe the nature of the current project or proposed expansion — what exactly is being done, why, and what it entails operationally."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Existing Expansion / Diversification Plans <span class="text-white/40">(for ongoing projects)</span></label>
                            <textarea x-model="form.expansion_plans" class="form-input" rows="4"
                                placeholder="For ongoing projects: describe any expansion or diversification plans, new product lines, new markets, or capacity increases."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 4 — DIRECTORS, MANAGEMENT & TECHNICAL STAFF   ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Directors --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">👔 List of Directors</h2>
                            <p class="text-white/50 text-sm">Directors and their shareholding percentage</p>
                        </div>
                        <button type="button" @click="addDirector()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Director
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(d, idx) in form.directors" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeDirector(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" x-model="d.name"         class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="d.nationality"  class="form-input text-sm" placeholder="Nationality">
                                    <input type="text" x-model="d.occupation"   class="form-input text-sm" placeholder="Occupation">
                                    <div class="flex items-center gap-2">
                                        <input type="number" x-model="d.shareholding" class="form-input text-sm flex-1" placeholder="Shareholding %" min="0" max="100">
                                        <span class="text-white/50 text-sm flex-shrink-0">%</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.directors.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                        Click "+ Add Director" to add directors
                    </div>
                </div>

                {{-- Management Staff --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">🗂️ Management Staff</h2>
                            <p class="text-white/50 text-sm">Senior management team</p>
                        </div>
                        <button type="button" @click="addManagement()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Manager
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(m, idx) in form.management_staff" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeManagement(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" x-model="m.name"        class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="m.position"    class="form-input text-sm" placeholder="Position/Title">
                                    <input type="text" x-model="m.qualification" class="form-input text-sm" placeholder="Qualification">
                                    <input type="number" x-model="m.experience"  class="form-input text-sm" placeholder="Years experience">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.management_staff.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                        Click "+ Add Manager" to add management staff
                    </div>
                </div>

                {{-- Technical Staff --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">🔧 Technical Staff</h2>
                            <p class="text-white/50 text-sm">Technical and specialist personnel</p>
                        </div>
                        <button type="button" @click="addTechnical()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Technical Staff
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(t, idx) in form.technical_staff" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeTechnical(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" x-model="t.name"         class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="t.specialisation" class="form-input text-sm" placeholder="Specialisation">
                                    <input type="text" x-model="t.qualification" class="form-input text-sm" placeholder="Qualification">
                                    <input type="number" x-model="t.experience"  class="form-input text-sm" placeholder="Years experience">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.technical_staff.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                        Click "+ Add Technical Staff"
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 5 — CVs OF KEY PERSONNEL                      ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">📋 CVs of Key Personnel</h2>
                            <p class="text-white/50 text-sm">Curriculum vitae for directors and key management</p>
                        </div>
                        <button type="button" @click="addCV()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add CV
                        </button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(cv, idx) in form.key_cvs" :key="idx">
                            <div class="glass rounded-xl p-5 relative">
                                <button type="button" @click="removeCV(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <input type="text" x-model="cv.name"     class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="cv.position" class="form-input text-sm" placeholder="Position">
                                    <input type="text" x-model="cv.email"    class="form-input text-sm" placeholder="Email (optional)">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="text-white/50 text-xs mb-1 block">Education / Qualifications</label>
                                        <textarea x-model="cv.education" class="form-input text-sm" rows="3"
                                            placeholder="e.g. B.Sc. Civil Engineering, University of Lagos, 1998&#10;MBA, Lagos Business School, 2005"></textarea>
                                    </div>
                                    <div>
                                        <label class="text-white/50 text-xs mb-1 block">Professional Experience</label>
                                        <textarea x-model="cv.experience" class="form-input text-sm" rows="3"
                                            placeholder="e.g. 15 years in construction industry&#10;Former MD at XYZ Construction 2010-2020"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-white/50 text-xs mb-1 block">Skills & Achievements</label>
                                    <textarea x-model="cv.skills" class="form-input text-sm" rows="2"
                                        placeholder="Key skills, certifications, awards, notable achievements..."></textarea>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.key_cvs.length === 0" class="text-center py-8 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                        Click "+ Add CV" to add curriculum vitae for key personnel
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 6 — MARKET ANALYSIS                           ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Market Size --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">🌍 Market Size</h2>
                    <p class="text-white/50 text-sm mb-6">TAM / SAM / SOM</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="form-label">TAM — Total Addressable Market (₦)</label>
                            <input type="number" x-model="form.tam" class="form-input" placeholder="e.g. 500000000000">
                        </div>
                        <div>
                            <label class="form-label">SAM — Serviceable Market (₦)</label>
                            <input type="number" x-model="form.sam" class="form-input" placeholder="e.g. 50000000000">
                        </div>
                        <div>
                            <label class="form-label">SOM — Obtainable Market (₦)</label>
                            <input type="number" x-model="form.som" class="form-input" placeholder="e.g. 500000000">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Overall Market Opportunity</label>
                        <textarea x-model="form.market_opportunity" class="form-input" rows="3" placeholder="General market overview and opportunity narrative."></textarea>
                    </div>
                </div>

                {{-- Supply Analysis --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">📦 Supply Analysis</h2>
                    <p class="text-white/50 text-sm mb-6">Information on existing suppliers and supply sources</p>
                    <div class="mb-4">
                        <label class="form-label">Supply Analysis Narrative</label>
                        <textarea x-model="form.supply_analysis" class="form-input" rows="4"
                            placeholder="Describe the current supply situation in the market — who are the existing suppliers, where they are located, their capacity, strengths and weaknesses, pricing etc."></textarea>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="form-label mb-0">Key Supply Sources / Existing Suppliers</label>
                        <button type="button" @click="addSupplySource()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Supplier
                        </button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(s, idx) in form.supply_sources" :key="idx">
                            <div class="flex gap-3 items-center">
                                <input type="text" x-model="s.name"     class="form-input flex-1 text-sm" placeholder="Supplier / Source name">
                                <input type="text" x-model="s.location" class="form-input flex-1 text-sm" placeholder="Location">
                                <input type="text" x-model="s.capacity" class="form-input w-32 text-sm"   placeholder="Capacity">
                                <button type="button" @click="removeSupplySource(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.supply_sources.length === 0" class="text-center py-4 text-white/30 text-xs border border-dashed border-white/10 rounded-xl mt-3">
                        Click "+ Add Supplier" to list supply sources
                    </div>
                </div>

                {{-- Demand Analysis --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">📊 Demand Analysis</h2>
                    <p class="text-white/50 text-sm mb-6">Factors influencing demand and market estimates</p>
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="form-label">Factors Influencing Demand</label>
                            <textarea x-model="form.demand_factors" class="form-input" rows="4"
                                placeholder="What drives demand for your product/service? e.g. population growth, urbanisation, income levels, policy changes, consumer trends, seasonality..."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Estimate of Domestic Demand</label>
                            <textarea x-model="form.domestic_demand" class="form-input" rows="4"
                                placeholder="Provide quantitative and qualitative estimates of domestic demand — volume, value, growth rate, historical trends, projected demand over 5 years..."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Export Potentials</label>
                            <textarea x-model="form.export_potential" class="form-input" rows="3"
                                placeholder="Is there potential to export? Which countries/regions? What is the estimated export market size? What are the requirements/barriers?"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Marketing Prospects --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">📣 Marketing Prospects</h2>
                    <p class="text-white/50 text-sm mb-6">Marketing strategy and competitive pricing</p>
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="form-label">Existing & Planned Marketing Arrangements</label>
                            <textarea x-model="form.marketing_arrangements" class="form-input" rows="4"
                                placeholder="Describe current and planned marketing activities — advertising channels, partnerships, sales team, agents, trade fairs, digital marketing etc."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Distribution Strategy</label>
                            <textarea x-model="form.distribution_strategy" class="form-input" rows="3"
                                placeholder="How will the product/service reach the customer? e.g. direct sales, distributors, retailers, e-commerce, agents, franchisees..."></textarea>
                        </div>
                        <div>
                            <label class="form-label">Pricing Analysis</label>
                            <textarea x-model="form.selling_price_analysis" class="form-input" rows="4"
                                placeholder="Current and proposed selling prices vs competitor prices. Include local market prices and import prices where applicable. Justify your pricing strategy."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Competitors --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">⚔️ Competitor Analysis</h2>
                            <p class="text-white/50 text-sm">Direct and indirect competitors</p>
                        </div>
                        <button type="button" @click="addCompetitor()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Competitor
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(comp, idx) in form.competitors" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeCompetitor(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                    <input type="text" x-model="comp.name"       class="form-input text-sm" placeholder="Name">
                                    <input type="text" x-model="comp.pricing"    class="form-input text-sm" placeholder="Pricing">
                                    <input type="text" x-model="comp.strengths"  class="form-input text-sm" placeholder="Strengths">
                                    <input type="text" x-model="comp.weaknesses" class="form-input text-sm" placeholder="Weaknesses">
                                    <select x-model="comp.threat" class="form-input text-sm">
                                        <option>Low threat</option><option>Medium threat</option><option>High threat</option>
                                    </select>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.competitors.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                        Click "+ Add Competitor"
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 7 — OPERATIONS                                ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 7" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Raw Materials --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">🧱 Sources of Raw Materials</h2>
                            <p class="text-white/50 text-sm">Key raw materials and their sources</p>
                        </div>
                        <button type="button" @click="addRawMaterial()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Material
                        </button>
                    </div>
                    <div class="grid grid-cols-5 gap-3 mb-2 px-1">
                        <div class="text-white/40 text-xs font-semibold uppercase">Material</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Supplier</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Location</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Unit Cost (₦)</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Availability</div>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(rm, idx) in form.raw_materials" :key="idx">
                            <div class="flex gap-2 items-center">
                                <div class="grid grid-cols-5 gap-2 flex-1">
                                    <input type="text"   x-model="rm.material"     class="form-input text-sm" placeholder="e.g. Steel">
                                    <input type="text"   x-model="rm.supplier"     class="form-input text-sm" placeholder="Supplier name">
                                    <input type="text"   x-model="rm.location"     class="form-input text-sm" placeholder="Location">
                                    <input type="number" x-model="rm.unit_cost"    class="form-input text-sm" placeholder="0">
                                    <select              x-model="rm.availability" class="form-input text-sm">
                                        <option>Readily available</option>
                                        <option>Seasonal</option>
                                        <option>Imported</option>
                                        <option>Limited</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeRawMaterial(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.raw_materials.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl mt-3">
                        Click "+ Add Material" to list raw materials
                    </div>
                </div>

                {{-- Machinery --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">⚙️ List of Machineries / Equipment</h2>
                            <p class="text-white/50 text-sm">Plant, machinery and major equipment</p>
                        </div>
                        <button type="button" @click="addMachinery()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Machinery
                        </button>
                    </div>
                    <div class="grid grid-cols-5 gap-3 mb-2 px-1">
                        <div class="text-white/40 text-xs font-semibold uppercase">Item</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Qty</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Unit Cost (₦)</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Supplier</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Status</div>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(mac, idx) in form.machineries" :key="idx">
                            <div class="flex gap-2 items-center">
                                <div class="grid grid-cols-5 gap-2 flex-1">
                                    <input type="text"   x-model="mac.name"      class="form-input text-sm" placeholder="e.g. Lathe Machine">
                                    <input type="number" x-model="mac.quantity"  class="form-input text-sm" placeholder="1">
                                    <input type="number" x-model="mac.unit_cost" class="form-input text-sm" placeholder="0">
                                    <input type="text"   x-model="mac.supplier"  class="form-input text-sm" placeholder="Supplier">
                                    <select              x-model="mac.status"    class="form-input text-sm">
                                        <option>New</option><option>Existing</option><option>To be procured</option><option>Leased</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeMachinery(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.machineries.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl mt-3">
                        Click "+ Add Machinery" to list equipment
                    </div>
                </div>

                {{-- Outstanding Liabilities --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">📑 Outstanding Liabilities <span class="text-white/30 text-sm font-normal">(Optional)</span></h2>
                            <p class="text-white/50 text-sm">Existing loans, obligations or payables</p>
                        </div>
                        <button type="button" @click="addLiability()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Liability
                        </button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(lib, idx) in form.liabilities" :key="idx">
                            <div class="flex gap-2 items-center">
                                <div class="grid grid-cols-4 gap-2 flex-1">
                                    <input type="text"   x-model="lib.creditor"  class="form-input text-sm" placeholder="Creditor / Lender">
                                    <input type="text"   x-model="lib.nature"    class="form-input text-sm" placeholder="Nature of liability">
                                    <input type="number" x-model="lib.amount"    class="form-input text-sm" placeholder="Amount (₦)">
                                    <input type="text"   x-model="lib.due_date"  class="form-input text-sm" placeholder="Due date / maturity">
                                </div>
                                <button type="button" @click="removeLiability(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.liabilities.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl mt-3">
                        No outstanding liabilities listed
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 8 — TEAM & MILESTONES                         ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="text-2xl font-bold mb-1">👥 Core Team Members</h2><p class="text-white/50 text-sm">Key people and their roles</p></div>
                        <button type="button" @click="addTeamMember()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1"><span class="text-lg leading-none">+</span> Add Member</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(member, idx) in form.team_members" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeTeamMember(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" x-model="member.name"     class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="member.role"     class="form-input text-sm" placeholder="Role/Title">
                                    <input type="text" x-model="member.linkedin" class="form-input text-sm" placeholder="LinkedIn (optional)">
                                    <textarea x-model="member.bio" class="form-input text-sm" placeholder="Brief bio" rows="2"></textarea>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.team_members.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">Click "+ Add Member"</div>
                </div>

                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="text-2xl font-bold mb-1">🗓️ Milestones & Roadmap</h2><p class="text-white/50 text-sm">Key milestones and implementation timeline</p></div>
                        <button type="button" @click="addMilestone()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1"><span class="text-lg leading-none">+</span> Add Milestone</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(ms, idx) in form.milestones" :key="idx">
                            <div class="glass rounded-xl p-4 relative">
                                <button type="button" @click="removeMilestone(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600 text-white font-bold">×</button>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" x-model="ms.date"  class="form-input text-sm" placeholder="Q1 2025">
                                    <input type="text" x-model="ms.title" class="form-input text-sm" placeholder="Milestone title">
                                    <textarea x-model="ms.description" class="form-input text-sm md:col-span-2" placeholder="What will be achieved?" rows="2"></textarea>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.milestones.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">Click "+ Add Milestone"</div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 9 — PROJECT COST & MANPOWER                   ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 9" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Project Cost --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">🏗️ Project Cost Breakdown</h2>
                            <p class="text-white/50 text-sm">Detailed cost components of the project</p>
                        </div>
                        <button type="button" @click="addProjectCost()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Cost Item
                        </button>
                    </div>
                    <div class="grid grid-cols-4 gap-3 mb-2 px-1">
                        <div class="text-white/40 text-xs font-semibold uppercase">Cost Item</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Description</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Amount (₦)</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Funding Source</div>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(pc, idx) in form.project_costs" :key="idx">
                            <div class="flex gap-2 items-center">
                                <div class="grid grid-cols-4 gap-2 flex-1">
                                    <input type="text"   x-model="pc.item"           class="form-input text-sm" placeholder="e.g. Land & Building">
                                    <input type="text"   x-model="pc.description"    class="form-input text-sm" placeholder="Details">
                                    <input type="number" x-model="pc.amount"         class="form-input text-sm" placeholder="0">
                                    <select              x-model="pc.funding_source"  class="form-input text-sm">
                                        <option>Equity</option><option>Bank Loan</option><option>Grant</option><option>Retained Earnings</option><option>Other</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeProjectCost(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.project_costs.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl mt-3">
                        Click "+ Add Cost Item" to list project costs
                    </div>
                    <div class="mt-4 p-4 glass rounded-xl">
                        <div class="flex justify-between items-center">
                            <span class="text-white/70 font-semibold">Total Project Cost:</span>
                            <span class="text-indigo-400 font-bold text-lg" x-text="'₦' + form.project_costs.reduce((s,i) => s + parseFloat(i.amount||0), 0).toLocaleString()"></span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="form-label">Financial Plan Narrative</label>
                        <textarea x-model="form.financial_plan_narrative" class="form-input" rows="4"
                            placeholder="Describe the financial plan — how the project will be financed, repayment schedule, evidence of availability of funds, collateral etc."></textarea>
                    </div>
                </div>

                {{-- Manpower --}}
                <div class="glass rounded-2xl p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">🧑‍💼 Manpower Plan</h2>
                            <p class="text-white/50 text-sm">Comprehensive manpower broken down by category and salary</p>
                        </div>
                        <button type="button" @click="addManpower()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                            <span class="text-lg leading-none">+</span> Add Category
                        </button>
                    </div>
                    <div class="grid grid-cols-5 gap-3 mb-2 px-1">
                        <div class="text-white/40 text-xs font-semibold uppercase">Category</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">No. of Staff</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Monthly Salary (₦)</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Annual Cost (₦)</div>
                        <div class="text-white/40 text-xs font-semibold uppercase">Qualification Req.</div>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(mp, idx) in form.manpower" :key="idx">
                            <div class="flex gap-2 items-center">
                                <div class="grid grid-cols-5 gap-2 flex-1">
                                    <input type="text"   x-model="mp.category"   class="form-input text-sm" placeholder="e.g. Senior Engineers">
                                    <input type="number" x-model="mp.count"      class="form-input text-sm" placeholder="5" @input="calcManpower(idx)">
                                    <input type="number" x-model="mp.salary"     class="form-input text-sm" placeholder="0" @input="calcManpower(idx)">
                                    <input type="text"   x-model="mp.annual_cost" class="form-input text-sm bg-white/5" readonly :value="'₦' + (parseFloat(mp.count||0) * parseFloat(mp.salary||0) * 12).toLocaleString()">
                                    <input type="text"   x-model="mp.qualification" class="form-input text-sm" placeholder="e.g. B.Sc Engineering">
                                </div>
                                <button type="button" @click="removeManpower(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                            </div>
                        </template>
                    </div>
                    <div x-show="form.manpower.length === 0" class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl mt-3">
                        Click "+ Add Category" to build your manpower plan
                    </div>
                    <div x-show="form.manpower.length > 0" class="mt-4 p-4 glass rounded-xl">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-white/70 font-semibold">Total Headcount:</span>
                            <span class="text-white font-bold" x-text="form.manpower.reduce((s,i) => s + parseInt(i.count||0), 0) + ' staff'"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/70 font-semibold">Total Annual Payroll:</span>
                            <span class="text-indigo-400 font-bold text-lg" x-text="'₦' + form.manpower.reduce((s,i) => s + parseFloat(i.count||0)*parseFloat(i.salary||0)*12, 0).toLocaleString()"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 10 — YEAR 1 FINANCIAL PROJECTIONS             ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 10" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">💰 Year 1 Financial Projections</h2>
                    <p class="text-white/50 text-sm mb-8">Monthly breakdown for the first year</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="form-label">Total Startup Costs (₦)</label>
                            <input type="number" x-model="form.startup_costs" class="form-input" placeholder="e.g. 50000000">
                        </div>
                        <div>
                            <label class="form-label">Price per Unit / Customer (₦)</label>
                            <input type="number" x-model="form.price_per_unit" class="form-input" placeholder="e.g. 99000">
                        </div>
                        <div>
                            <label class="form-label">Variable Cost per Unit (₦)</label>
                            <input type="number" x-model="form.variable_cost_per_unit" class="form-input" placeholder="e.g. 30000">
                        </div>
                        <div>
                            <label class="form-label">Fixed Monthly Costs (₦)</label>
                            <input type="number" x-model="form.fixed_costs_monthly" class="form-input" placeholder="e.g. 2000000">
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <label class="form-label mb-0">Monthly Expense Breakdown</label>
                            <button type="button" @click="addExpense()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1"><span class="text-lg leading-none">+</span> Add</button>
                        </div>
                        <div class="space-y-2">
                            <template x-for="(exp, idx) in form.monthly_expenses" :key="idx">
                                <div class="flex gap-3 items-center">
                                    <input type="text"   x-model="exp.category" class="form-input flex-1 text-sm" placeholder="Category">
                                    <input type="number" x-model="exp.amount"   class="form-input w-44 text-sm"   placeholder="Amount (₦)">
                                    <button type="button" @click="removeExpense(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 font-bold flex-shrink-0">×</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="form-label">Monthly Revenue Projections — Year 1 (₦)</label>
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-3 mt-3">
                            <template x-for="(month, idx) in form.revenue_projections" :key="idx">
                                <div>
                                    <label class="text-white/50 text-xs mb-1 block" x-text="month.label"></label>
                                    <input type="number" x-model="month.revenue" class="form-input text-sm px-3 py-2" placeholder="0">
                                </div>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Monthly Cash Inflow vs Outflow — Year 1 (₦)</label>
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-white/50">
                                        <th class="text-left py-2 pr-3 font-medium w-14">Month</th>
                                        <th class="text-left py-2 pr-3 font-medium">Inflow (₦)</th>
                                        <th class="text-left py-2 font-medium">Outflow (₦)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(cf, idx) in form.cashflow_data" :key="idx">
                                        <tr>
                                            <td class="pr-3 py-1 text-white/60 font-medium" x-text="cf.label"></td>
                                            <td class="pr-3 py-1"><input type="number" x-model="cf.inflow"  class="form-input text-sm px-3 py-2" placeholder="0"></td>
                                            <td class="py-1">    <input type="number" x-model="cf.outflow" class="form-input text-sm px-3 py-2" placeholder="0"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════════════════════════════╗
                 ║  STEP 11 — 5-YEAR CONSOLIDATED PROJECTIONS          ║
                 ╚══════════════════════════════════════════════════════╝ --}}
            <div x-show="currentStep === 11" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">📈 5-Year Consolidated Projections</h2>
                    <p class="text-white/50 text-sm mb-8">Profit & Loss, Cashflow and Balance Sheet for Years 1–5</p>

                    {{-- P&L --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-indigo-400 mb-4">📊 Profit & Loss Account</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-white/50 border-b border-white/10">
                                        <th class="text-left py-3 pr-4 font-semibold w-48">Item</th>
                                        @for($y = 1; $y <= 5; $y++)
                                        <th class="text-right py-3 px-2 font-semibold">Year {{ $y }} (₦)</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['revenue' => 'Revenue / Turnover', 'cogs' => 'Cost of Goods Sold', 'gross_profit' => 'Gross Profit', 'operating_expenses' => 'Operating Expenses', 'ebitda' => 'EBITDA', 'depreciation' => 'Depreciation', 'interest' => 'Interest Expense', 'ebt' => 'Profit Before Tax', 'tax' => 'Tax', 'net_profit' => 'Net Profit After Tax'] as $key => $label)
                                    <tr class="border-b border-white/5 {{ in_array($key, ['gross_profit','ebitda','net_profit']) ? 'bg-white/5' : '' }}">
                                        <td class="py-2 pr-4 text-white/70 font-medium {{ in_array($key, ['gross_profit','ebitda','net_profit']) ? 'text-white font-semibold' : '' }}">{{ $label }}</td>
                                        @for($y = 1; $y <= 5; $y++)
                                        <td class="py-2 px-2">
                                            <input type="number" x-model="form.five_year_projections.pl.{{ $key }}[{{ $y-1 }}]" class="form-input text-sm px-2 py-1 text-right" placeholder="0">
                                        </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Cashflow --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-emerald-400 mb-4">💵 Cash Flow Statement</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-white/50 border-b border-white/10">
                                        <th class="text-left py-3 pr-4 font-semibold w-48">Item</th>
                                        @for($y = 1; $y <= 5; $y++)
                                        <th class="text-right py-3 px-2 font-semibold">Year {{ $y }} (₦)</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['operating_cashflow' => 'Operating Cash Flow', 'investing_cashflow' => 'Investing Cash Flow', 'financing_cashflow' => 'Financing Cash Flow', 'net_cashflow' => 'Net Cash Flow', 'opening_balance' => 'Opening Cash Balance', 'closing_balance' => 'Closing Cash Balance'] as $key => $label)
                                    <tr class="border-b border-white/5 {{ in_array($key, ['net_cashflow','closing_balance']) ? 'bg-white/5' : '' }}">
                                        <td class="py-2 pr-4 text-white/70 font-medium {{ in_array($key, ['net_cashflow','closing_balance']) ? 'text-white font-semibold' : '' }}">{{ $label }}</td>
                                        @for($y = 1; $y <= 5; $y++)
                                        <td class="py-2 px-2">
                                            <input type="number" x-model="form.five_year_projections.cf.{{ $key }}[{{ $y-1 }}]" class="form-input text-sm px-2 py-1 text-right" placeholder="0">
                                        </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Balance Sheet --}}
                    <div>
                        <h3 class="text-lg font-bold text-purple-400 mb-4">🏦 Balance Sheet</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-white/50 border-b border-white/10">
                                        <th class="text-left py-3 pr-4 font-semibold w-48">Item</th>
                                        @for($y = 1; $y <= 5; $y++)
                                        <th class="text-right py-3 px-2 font-semibold">Year {{ $y }} (₦)</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="6" class="py-2 text-indigo-400 font-bold text-xs uppercase tracking-wider">Assets</td></tr>
                                    @foreach(['fixed_assets' => 'Fixed Assets', 'current_assets' => 'Current Assets', 'total_assets' => 'Total Assets'] as $key => $label)
                                    <tr class="border-b border-white/5 {{ $key === 'total_assets' ? 'bg-white/5 font-semibold' : '' }}">
                                        <td class="py-2 pr-4 text-white/70 font-medium">{{ $label }}</td>
                                        @for($y = 1; $y <= 5; $y++)
                                        <td class="py-2 px-2"><input type="number" x-model="form.five_year_projections.bs.{{ $key }}[{{ $y-1 }}]" class="form-input text-sm px-2 py-1 text-right" placeholder="0"></td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                    <tr><td colspan="6" class="py-2 text-indigo-400 font-bold text-xs uppercase tracking-wider pt-4">Liabilities & Equity</td></tr>
                                    @foreach(['current_liabilities' => 'Current Liabilities', 'long_term_liabilities' => 'Long-Term Liabilities', 'equity' => 'Shareholders Equity', 'total_liabilities_equity' => 'Total Liabilities & Equity'] as $key => $label)
                                    <tr class="border-b border-white/5 {{ $key === 'total_liabilities_equity' ? 'bg-white/5 font-semibold' : '' }}">
                                        <td class="py-2 pr-4 text-white/70 font-medium">{{ $label }}</td>
                                        @for($y = 1; $y <= 5; $y++)
                                        <td class="py-2 px-2"><input type="number" x-model="form.five_year_projections.bs.{{ $key }}[{{ $y-1 }}]" class="form-input text-sm px-2 py-1 text-right" placeholder="0"></td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="flex justify-between items-center mt-6">
                <button type="button" @click="prevStep()" x-show="currentStep > 1" class="btn-secondary">← Back</button>
                <div x-show="currentStep === 1"></div>
                <div class="flex items-center gap-3">
                    <span class="text-white/30 text-sm" x-text="`Step ${currentStep} of 11`"></span>
                    <button type="button" @click="nextStep()" x-show="currentStep < 11" class="btn-primary">Next Step →</button>
                    <button type="button" x-show="currentStep === 11" onclick="window.doSubmit()" class="btn-primary text-lg px-10 py-4" id="generateBtn">
                        🚀 Generate Business Plan
                    </button>
                </div>
            </div>
            <div x-show="validationError" x-transition class="mt-4 bg-red-500/20 border border-red-500/40 text-red-300 px-5 py-3 rounded-xl text-sm" x-text="validationError"></div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function bizPlanWizard() {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const years5 = () => [0,0,0,0,0];

    return {
        currentStep: 1,
        validationError: '',
        logoPreview: null,
        photoPreviews: [],
        form: {
            // Step 1
            company_name:'', tagline:'', industry:'', rc_number:'', incorporation_date:'',
            business_stage:'Idea', location:'', primary_color:'#6366f1', secondary_color:'#8b5cf6',
            // Step 2
            business_model:'', problem_statement:'', solution:'', value_proposition:'',
            target_market:'', revenue_streams:'', funding_required:'', use_of_funds:'',
            // Step 3
            company_history:'', activities_since_inc:'', project_nature:'', expansion_plans:'',
            // Step 4
            directors:[], management_staff:[], technical_staff:[],
            // Step 5
            key_cvs:[],
            // Step 6
            tam:'', sam:'', som:'', market_opportunity:'',
            supply_analysis:'', supply_sources:[],
            demand_factors:'', domestic_demand:'', export_potential:'',
            marketing_arrangements:'', distribution_strategy:'', selling_price_analysis:'',
            competitors:[],
            // Step 7
            raw_materials:[], machineries:[], liabilities:[],
            // Step 8
            team_members:[], milestones:[],
            // Step 9
            project_costs:[], financial_plan_narrative:'',
            manpower:[],
            // Step 10
            startup_costs:'', price_per_unit:'', variable_cost_per_unit:'', fixed_costs_monthly:'',
            monthly_expenses:[
                {category:'Salaries',amount:0},{category:'Marketing',amount:0},
                {category:'Operations',amount:0},{category:'Technology',amount:0},
                {category:'Office / Rent',amount:0},{category:'Miscellaneous',amount:0},
            ],
            revenue_projections: months.map(m => ({label:m, revenue:0})),
            cashflow_data: months.map(m => ({label:m, inflow:0, outflow:0})),
            // Step 11
            five_year_projections: {
                pl: {
                    revenue:years5(), cogs:years5(), gross_profit:years5(),
                    operating_expenses:years5(), ebitda:years5(), depreciation:years5(),
                    interest:years5(), ebt:years5(), tax:years5(), net_profit:years5(),
                },
                cf: {
                    operating_cashflow:years5(), investing_cashflow:years5(),
                    financing_cashflow:years5(), net_cashflow:years5(),
                    opening_balance:years5(), closing_balance:years5(),
                },
                bs: {
                    fixed_assets:years5(), current_assets:years5(), total_assets:years5(),
                    current_liabilities:years5(), long_term_liabilities:years5(),
                    equity:years5(), total_liabilities_equity:years5(),
                },
            },
        },

        nextStep() {
            this.validationError = '';
            if (this.currentStep === 1 && !this.form.company_name.trim()) {
                this.validationError = 'Please enter your company name.'; return;
            }
            if (this.currentStep < 11) { this.currentStep++; window.scrollTo({top:0,behavior:'smooth'}); }
        },
        prevStep() {
            this.validationError = '';
            if (this.currentStep > 1) { this.currentStep--; window.scrollTo({top:0,behavior:'smooth'}); }
        },
        previewLogo(e) {
            const file = e.target.files[0]; if (!file) return;
            const r = new FileReader(); r.onload = ev => { this.logoPreview = ev.target.result; }; r.readAsDataURL(file);
        },
        previewPhotos(e) {
            this.photoPreviews = [];
            Array.from(e.target.files).slice(0,3).forEach(f => {
                const r = new FileReader(); r.onload = ev => { this.photoPreviews.push(ev.target.result); }; r.readAsDataURL(f);
            });
        },
        calcManpower(idx) { /* annual cost auto-calculated via template expression */ },

        // Step 1
        // Step 4
        addDirector()      { this.form.directors.push({name:'',nationality:'',occupation:'',shareholding:''}); },
        removeDirector(i)  { this.form.directors.splice(i,1); },
        addManagement()    { this.form.management_staff.push({name:'',position:'',qualification:'',experience:''}); },
        removeManagement(i){ this.form.management_staff.splice(i,1); },
        addTechnical()     { this.form.technical_staff.push({name:'',specialisation:'',qualification:'',experience:''}); },
        removeTechnical(i) { this.form.technical_staff.splice(i,1); },
        // Step 5
        addCV()            { this.form.key_cvs.push({name:'',position:'',email:'',education:'',experience:'',skills:''}); },
        removeCV(i)        { this.form.key_cvs.splice(i,1); },
        // Step 6
        addCompetitor()    { this.form.competitors.push({name:'',pricing:'',strengths:'',weaknesses:'',threat:'Medium threat'}); },
        removeCompetitor(i){ this.form.competitors.splice(i,1); },
        addSupplySource()  { this.form.supply_sources.push({name:'',location:'',capacity:''}); },
        removeSupplySource(i){ this.form.supply_sources.splice(i,1); },
        // Step 7
        addRawMaterial()   { this.form.raw_materials.push({material:'',supplier:'',location:'',unit_cost:'',availability:'Readily available'}); },
        removeRawMaterial(i){ this.form.raw_materials.splice(i,1); },
        addMachinery()     { this.form.machineries.push({name:'',quantity:'',unit_cost:'',supplier:'',status:'New'}); },
        removeMachinery(i) { this.form.machineries.splice(i,1); },
        addLiability()     { this.form.liabilities.push({creditor:'',nature:'',amount:'',due_date:''}); },
        removeLiability(i) { this.form.liabilities.splice(i,1); },
        // Step 8
        addTeamMember()    { this.form.team_members.push({name:'',role:'',linkedin:'',bio:''}); },
        removeTeamMember(i){ this.form.team_members.splice(i,1); },
        addMilestone()     { this.form.milestones.push({date:'',title:'',description:''}); },
        removeMilestone(i) { this.form.milestones.splice(i,1); },
        // Step 9
        addProjectCost()   { this.form.project_costs.push({item:'',description:'',amount:'',funding_source:'Equity'}); },
        removeProjectCost(i){ this.form.project_costs.splice(i,1); },
        addManpower()      { this.form.manpower.push({category:'',count:'',salary:'',annual_cost:'',qualification:''}); },
        removeManpower(i)  { this.form.manpower.splice(i,1); },
        // Step 10
        addExpense()       { this.form.monthly_expenses.push({category:'',amount:0}); },
        removeExpense(i)   { this.form.monthly_expenses.splice(i,1); },
    };
}

window.doSubmit = function() {
    const root = document.querySelector('[x-data]');
    const data = root._x_dataStack ? root._x_dataStack[0] : Alpine.$data(root);

    if (!data.form.company_name || !data.form.company_name.trim()) {
        data.validationError = 'Company name is required. Please go back to Step 1.'; return;
    }

    const btn = document.getElementById('generateBtn');
    btn.textContent = '⏳ Generating...'; btn.disabled = true;

    const scalars = [
        'company_name','tagline','industry','founded_year','rc_number','incorporation_date',
        'business_stage','location','primary_color','secondary_color',
        'business_model','problem_statement','solution','value_proposition',
        'target_market','revenue_streams','funding_required','use_of_funds',
        'company_history','activities_since_inc','project_nature','expansion_plans',
        'market_opportunity','supply_analysis','demand_factors','domestic_demand','export_potential',
        'marketing_arrangements','distribution_strategy','selling_price_analysis',
        'project_cost_description','financial_plan_narrative',
        'startup_costs','price_per_unit','variable_cost_per_unit','fixed_costs_monthly',
    ];
    scalars.forEach(key => {
        const el = document.getElementById('h_' + key);
        if (el) el.value = data.form[key] != null ? data.form[key] : '';
    });

    const jsonFields = [
        'directors','management_staff','technical_staff','key_cvs',
        'competitors','supply_sources',
        'raw_materials','machineries','liabilities',
        'team_members','milestones',
        'project_costs','manpower',
        'monthly_expenses','revenue_projections','cashflow_data',
        'five_year_projections',
    ];
    jsonFields.forEach(key => {
        const el = document.getElementById('h_' + key);
        if (el) el.value = JSON.stringify(data.form[key]);
    });

    document.getElementById('mainForm').submit();
};
</script>
@endpush
@endsection
