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
        <p class="text-white/50 text-sm">Generate a professional business plan in minutes</p>
    </div>

    {{-- Progress Steps --}}
    <div class="max-w-4xl mx-auto px-6 mb-8">
        <div class="flex items-center justify-center gap-2">
            @foreach([
                ['icon'=>'🏢','label'=>'Company'],
                ['icon'=>'💡','label'=>'Business'],
                ['icon'=>'🌍','label'=>'Market'],
                ['icon'=>'👥','label'=>'Team'],
                ['icon'=>'💰','label'=>'Financials'],
            ] as $i => $step)
            <div class="flex items-center gap-2">
                <div class="flex flex-col items-center gap-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg transition-all duration-300 font-bold text-sm"
                         :class="currentStep > {{ $i+1 }} ? 'step-done' : (currentStep === {{ $i+1 }} ? 'step-active' : 'step-inactive')">
                        <span x-show="currentStep > {{ $i+1 }}">✓</span>
                        <span x-show="currentStep <= {{ $i+1 }}">{{ $step['icon'] }}</span>
                    </div>
                    <span class="text-xs transition-all" :class="currentStep === {{ $i+1 }} ? 'text-indigo-400 font-semibold' : 'text-white/30'">{{ $step['label'] }}</span>
                </div>
                @if($i < 4)
                <div class="w-8 h-px mb-5 transition-all duration-500" :class="currentStep > {{ $i+1 }} ? 'bg-emerald-400' : 'bg-white/10'"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('generate') }}" method="POST" enctype="multipart/form-data" id="bizPlanForm">
        @csrf

        {{-- Hidden JSON fields populated by Alpine --}}
        <input type="hidden" name="monthly_expenses"    :value="JSON.stringify(form.monthly_expenses)">
        <input type="hidden" name="revenue_projections" :value="JSON.stringify(form.revenue_projections)">
        <input type="hidden" name="cashflow_data"       :value="JSON.stringify(form.cashflow_data)">
        <input type="hidden" name="competitors"         :value="JSON.stringify(form.competitors)">
        <input type="hidden" name="team_members"        :value="JSON.stringify(form.team_members)">
        <input type="hidden" name="milestones"          :value="JSON.stringify(form.milestones)">

        <div class="max-w-4xl mx-auto px-6 pb-16">

            {{-- ======================== STEP 1: COMPANY & BRANDING ======================== --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">🏢 Company & Branding</h2>
                    <p class="text-white/50 text-sm mb-8">Basic information about your company</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="company_name" x-model="form.company_name" class="form-input" placeholder="e.g. Acme Corp" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Tagline / Slogan</label>
                            <input type="text" name="tagline" x-model="form.tagline" class="form-input" placeholder="e.g. Empowering the future of work">
                        </div>
                        <div>
                            <label class="form-label">Industry *</label>
                            <select name="industry" x-model="form.industry" class="form-input" required>
                                <option value="">Select industry...</option>
                                <option>Technology / SaaS</option>
                                <option>E-Commerce / Retail</option>
                                <option>Healthcare</option>
                                <option>Fintech</option>
                                <option>Education</option>
                                <option>Real Estate</option>
                                <option>Food & Beverage</option>
                                <option>Manufacturing</option>
                                <option>Consulting / Services</option>
                                <option>Media & Entertainment</option>
                                <option>Agriculture</option>
                                <option>Transportation & Logistics</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Founded Year</label>
                            <input type="number" name="founded_year" x-model="form.founded_year" class="form-input" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') + 5 }}">
                        </div>
                        <div>
                            <label class="form-label">Business Stage</label>
                            <select name="business_stage" x-model="form.business_stage" class="form-input">
                                <option value="Idea">Idea Stage</option>
                                <option value="MVP">MVP / Prototype</option>
                                <option value="Early">Early Revenue</option>
                                <option value="Growth">Growth Stage</option>
                                <option value="Scaling">Scaling</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Location / HQ</label>
                            <input type="text" name="location" x-model="form.location" class="form-input" placeholder="e.g. Lagos, Nigeria">
                        </div>

                        {{-- Logo Upload --}}
                        <div>
                            <label class="form-label">Company Logo</label>
                            <div class="border-2 border-dashed border-white/20 rounded-xl p-4 text-center hover:border-indigo-400 transition-colors cursor-pointer relative"
                                 @click="$refs.logoInput.click()">
                                <template x-if="!logoPreview">
                                    <div>
                                        <div class="text-3xl mb-2">🖼️</div>
                                        <p class="text-white/50 text-sm">Click to upload logo</p>
                                        <p class="text-white/30 text-xs">PNG, JPG up to 2MB</p>
                                    </div>
                                </template>
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" class="max-h-20 mx-auto rounded-lg object-contain">
                                </template>
                                <input type="file" name="logo" accept="image/*" x-ref="logoInput" class="hidden"
                                       @change="previewLogo($event)">
                            </div>
                        </div>

                        {{-- Business Photos --}}
                        <div>
                            <label class="form-label">Business Photos <span class="text-white/40">(optional, up to 3)</span></label>
                            <div class="border-2 border-dashed border-white/20 rounded-xl p-4 text-center hover:border-indigo-400 transition-colors cursor-pointer"
                                 @click="$refs.photosInput.click()">
                                <div x-show="photoPreviews.length === 0">
                                    <div class="text-3xl mb-2">📸</div>
                                    <p class="text-white/50 text-sm">Click to upload photos</p>
                                    <p class="text-white/30 text-xs">PNG, JPG up to 4MB each</p>
                                </div>
                                <div x-show="photoPreviews.length > 0" class="flex gap-2 flex-wrap justify-center">
                                    <template x-for="photo in photoPreviews" :key="photo">
                                        <img :src="photo" class="h-14 w-14 object-cover rounded-lg">
                                    </template>
                                </div>
                                <input type="file" name="business_photos[]" accept="image/*" multiple x-ref="photosInput" class="hidden"
                                       @change="previewPhotos($event)">
                            </div>
                        </div>

                        {{-- Brand Colors --}}
                        <div>
                            <label class="form-label">Primary Brand Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="primary_color" x-model="form.primary_color" class="cursor-pointer rounded-xl border border-white/20" value="#6366f1">
                                <span class="text-white/60 font-mono text-sm" x-text="form.primary_color"></span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Secondary Brand Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="secondary_color" x-model="form.secondary_color" class="cursor-pointer rounded-xl border border-white/20" value="#8b5cf6">
                                <span class="text-white/60 font-mono text-sm" x-text="form.secondary_color"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================== STEP 2: BUSINESS DETAILS ======================== --}}
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">💡 Business Details</h2>
                    <p class="text-white/50 text-sm mb-8">Describe your business concept</p>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="form-label">Business Model *</label>
                            <select name="business_model" x-model="form.business_model" class="form-input" required>
                                <option value="">Select model...</option>
                                <option>B2B SaaS</option>
                                <option>B2C SaaS</option>
                                <option>Marketplace</option>
                                <option>E-Commerce</option>
                                <option>Subscription</option>
                                <option>Freemium</option>
                                <option>Franchise</option>
                                <option>Direct Sales</option>
                                <option>Consulting / Services</option>
                                <option>Advertising</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Problem Statement *</label>
                            <textarea name="problem_statement" x-model="form.problem_statement" class="form-input" placeholder="What problem does your business solve? Describe the pain point clearly." required></textarea>
                        </div>
                        <div>
                            <label class="form-label">Your Solution *</label>
                            <textarea name="solution" x-model="form.solution" class="form-input" placeholder="How does your product/service solve the problem?" required></textarea>
                        </div>
                        <div>
                            <label class="form-label">Unique Value Proposition *</label>
                            <textarea name="value_proposition" x-model="form.value_proposition" class="form-input" placeholder="What makes your business unique? Why should customers choose you?" required></textarea>
                        </div>
                        <div>
                            <label class="form-label">Target Market / Customers *</label>
                            <textarea name="target_market" x-model="form.target_market" class="form-input" placeholder="Describe your ideal customers: demographics, psychographics, behaviors." required></textarea>
                        </div>
                        <div>
                            <label class="form-label">Revenue Streams</label>
                            <textarea name="revenue_streams" x-model="form.revenue_streams" class="form-input" placeholder="e.g. Subscription fees, transaction fees, advertising, licensing..." rows="3"></textarea>
                        </div>
                        <div>
                            <label class="form-label">Funding Required ($)</label>
                            <input type="number" name="funding_required" x-model="form.funding_required" class="form-input" placeholder="e.g. 500000">
                        </div>
                        <div>
                            <label class="form-label">Use of Funds</label>
                            <textarea name="use_of_funds" x-model="form.use_of_funds" class="form-input" placeholder="e.g. 40% Product Development, 30% Marketing, 20% Operations, 10% Working Capital" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================== STEP 3: MARKET & COMPETITORS ======================== --}}
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">🌍 Market & Competitors</h2>
                    <p class="text-white/50 text-sm mb-8">Define your market size and competitive landscape</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="form-label">TAM - Total Addressable Market ($) *</label>
                            <input type="number" name="tam" x-model="form.tam" class="form-input" placeholder="e.g. 50000000000" required>
                            <p class="text-white/30 text-xs mt-1">Total global market value</p>
                        </div>
                        <div>
                            <label class="form-label">SAM - Serviceable Market ($) *</label>
                            <input type="number" name="sam" x-model="form.sam" class="form-input" placeholder="e.g. 5000000000" required>
                            <p class="text-white/30 text-xs mt-1">Market you can realistically target</p>
                        </div>
                        <div>
                            <label class="form-label">SOM - Obtainable Market ($) *</label>
                            <input type="number" name="som" x-model="form.som" class="form-input" placeholder="e.g. 50000000" required>
                            <p class="text-white/30 text-xs mt-1">Your realistic 3-5 year capture</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="form-label">Market Opportunity Description</label>
                        <textarea name="market_opportunity" x-model="form.market_opportunity" class="form-input" placeholder="Describe the market opportunity, growth trends, and why now is the right time." rows="3"></textarea>
                    </div>

                    {{-- Competitors --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="form-label mb-0">Competitor Analysis</label>
                            <button type="button" @click="addCompetitor()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                                <span class="text-lg">+</span> Add Competitor
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(comp, idx) in form.competitors" :key="idx">
                                <div class="glass rounded-xl p-4 grid grid-cols-2 md:grid-cols-5 gap-3 relative">
                                    <button type="button" @click="removeCompetitor(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600">×</button>
                                    <input type="text" x-model="comp.name" class="form-input text-sm" placeholder="Competitor name">
                                    <input type="text" x-model="comp.pricing" class="form-input text-sm" placeholder="Pricing">
                                    <input type="text" x-model="comp.strengths" class="form-input text-sm" placeholder="Their strengths">
                                    <input type="text" x-model="comp.weaknesses" class="form-input text-sm" placeholder="Their weaknesses">
                                    <select x-model="comp.threat" class="form-input text-sm">
                                        <option>Low threat</option>
                                        <option>Medium threat</option>
                                        <option>High threat</option>
                                    </select>
                                </div>
                            </template>
                        </div>

                        <template x-if="form.competitors.length === 0">
                            <div class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                                Click "+ Add Competitor" to add competitors
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ======================== STEP 4: TEAM & MILESTONES ======================== --}}
            <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">👥 Team & Milestones</h2>
                    <p class="text-white/50 text-sm mb-8">Your core team and growth roadmap</p>

                    {{-- Team Members --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <label class="form-label mb-0">Team Members</label>
                            <button type="button" @click="addTeamMember()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                                <span class="text-lg">+</span> Add Member
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(member, idx) in form.team_members" :key="idx">
                                <div class="glass rounded-xl p-4 grid grid-cols-1 md:grid-cols-4 gap-3 relative">
                                    <button type="button" @click="removeTeamMember(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600">×</button>
                                    <input type="text" x-model="member.name" class="form-input text-sm" placeholder="Full name">
                                    <input type="text" x-model="member.role" class="form-input text-sm" placeholder="Role/Title">
                                    <input type="text" x-model="member.linkedin" class="form-input text-sm" placeholder="LinkedIn (optional)">
                                    <textarea x-model="member.bio" class="form-input text-sm" placeholder="Brief bio / expertise" rows="2"></textarea>
                                </div>
                            </template>
                        </div>
                        <template x-if="form.team_members.length === 0">
                            <div class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                                Click "+ Add Member" to add team members
                            </div>
                        </template>
                    </div>

                    {{-- Milestones --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="form-label mb-0">Key Milestones / Roadmap</label>
                            <button type="button" @click="addMilestone()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                                <span class="text-lg">+</span> Add Milestone
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(ms, idx) in form.milestones" :key="idx">
                                <div class="glass rounded-xl p-4 grid grid-cols-1 md:grid-cols-4 gap-3 relative">
                                    <button type="button" @click="removeMilestone(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-xs flex items-center justify-center hover:bg-red-600">×</button>
                                    <input type="text" x-model="ms.date" class="form-input text-sm" placeholder="Q1 2025 / Jan 2025">
                                    <input type="text" x-model="ms.title" class="form-input text-sm" placeholder="Milestone title">
                                    <textarea x-model="ms.description" class="form-input text-sm md:col-span-2" placeholder="What will be achieved?" rows="2"></textarea>
                                </div>
                            </template>
                        </div>
                        <template x-if="form.milestones.length === 0">
                            <div class="text-center py-6 text-white/30 text-sm border border-dashed border-white/10 rounded-xl">
                                Click "+ Add Milestone" to add roadmap items
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ======================== STEP 5: FINANCIALS ======================== --}}
            <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass rounded-2xl p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-1">💰 Financial Projections</h2>
                    <p class="text-white/50 text-sm mb-8">Enter your financial data for charts and analysis</p>

                    {{-- Startup Costs --}}
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="form-label">Total Startup Costs ($) *</label>
                                <input type="number" name="startup_costs" x-model="form.startup_costs" class="form-input" placeholder="e.g. 150000" required>
                            </div>
                            <div>
                                <label class="form-label">Price per Unit/Customer ($) *</label>
                                <input type="number" name="price_per_unit" x-model="form.price_per_unit" class="form-input" placeholder="e.g. 99" required>
                            </div>
                            <div>
                                <label class="form-label">Variable Cost per Unit ($) *</label>
                                <input type="number" name="variable_cost_per_unit" x-model="form.variable_cost_per_unit" class="form-input" placeholder="e.g. 30" required>
                            </div>
                            <div>
                                <label class="form-label">Fixed Monthly Costs ($) *</label>
                                <input type="number" name="fixed_costs_monthly" x-model="form.fixed_costs_monthly" class="form-input" placeholder="e.g. 20000" required>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Expense Breakdown --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <label class="form-label mb-0">Monthly Expense Breakdown (for Pie Chart)</label>
                            <button type="button" @click="addExpense()" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center gap-1">
                                <span class="text-lg">+</span> Add Category
                            </button>
                        </div>
                        <div class="space-y-2">
                            <template x-for="(exp, idx) in form.monthly_expenses" :key="idx">
                                <div class="flex gap-3 items-center">
                                    <input type="text" x-model="exp.category" class="form-input flex-1 text-sm" placeholder="Category (e.g. Salaries)">
                                    <input type="number" x-model="exp.amount" class="form-input w-40 text-sm" placeholder="Amount ($)">
                                    <button type="button" @click="removeExpense(idx)" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/40 rounded-lg flex items-center justify-center text-red-400 flex-shrink-0">×</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Revenue Projections (12 months) --}}
                    <div class="mb-8">
                        <label class="form-label">Monthly Revenue Projections — Year 1 ($)</label>
                        <p class="text-white/30 text-xs mb-3">Enter expected monthly revenue for each month</p>
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                            <template x-for="(month, idx) in form.revenue_projections" :key="idx">
                                <div>
                                    <label class="text-white/50 text-xs mb-1 block" x-text="month.label"></label>
                                    <input type="number" x-model="month.revenue" class="form-input text-sm px-3 py-2" placeholder="0">
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Cashflow (12 months) --}}
                    <div>
                        <label class="form-label">Monthly Cash Inflow vs Outflow — Year 1 ($)</label>
                        <p class="text-white/30 text-xs mb-3">Enter inflow (income) and outflow (expenses) for each month</p>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-white/50">
                                        <th class="text-left py-2 pr-3 font-medium">Month</th>
                                        <th class="text-left py-2 pr-3 font-medium">Inflow ($)</th>
                                        <th class="text-left py-2 font-medium">Outflow ($)</th>
                                    </tr>
                                </thead>
                                <tbody class="space-y-2">
                                    <template x-for="(cf, idx) in form.cashflow_data" :key="idx">
                                        <tr>
                                            <td class="pr-3 py-1 text-white/60 font-medium w-16" x-text="cf.label"></td>
                                            <td class="pr-3 py-1">
                                                <input type="number" x-model="cf.inflow" class="form-input text-sm px-3 py-2" placeholder="0">
                                            </td>
                                            <td class="py-1">
                                                <input type="number" x-model="cf.outflow" class="form-input text-sm px-3 py-2" placeholder="0">
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex justify-between items-center">
                <button type="button" @click="prevStep()" x-show="currentStep > 1" class="btn-secondary">
                    ← Back
                </button>
                <div x-show="currentStep === 1" class="w-1"></div>

                <div class="flex items-center gap-3">
                    <span class="text-white/30 text-sm" x-text="`Step ${currentStep} of 5`"></span>
                    <button type="button" @click="nextStep()" x-show="currentStep < 5" class="btn-primary">
                        Next Step →
                    </button>
                    <button type="submit" x-show="currentStep === 5" class="btn-primary text-lg px-10 py-4">
                        🚀 Generate Business Plan
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

@if(session('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50" x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false, 4000)">
    {{ session('error') }}
</div>
@endif

@push('scripts')
<script>
function bizPlanWizard() {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    return {
        currentStep: 1,
        logoPreview: null,
        photoPreviews: [],
        form: {
            company_name: '',
            tagline: '',
            industry: '',
            founded_year: '',
            business_stage: 'Idea',
            location: '',
            primary_color: '#6366f1',
            secondary_color: '#8b5cf6',
            business_model: '',
            problem_statement: '',
            solution: '',
            value_proposition: '',
            target_market: '',
            revenue_streams: '',
            funding_required: '',
            use_of_funds: '',
            market_opportunity: '',
            tam: '',
            sam: '',
            som: '',
            competitors: [],
            team_members: [],
            milestones: [],
            startup_costs: '',
            price_per_unit: '',
            variable_cost_per_unit: '',
            fixed_costs_monthly: '',
            monthly_expenses: [
                { category: 'Salaries', amount: 0 },
                { category: 'Marketing', amount: 0 },
                { category: 'Operations', amount: 0 },
                { category: 'Technology', amount: 0 },
                { category: 'Office / Rent', amount: 0 },
                { category: 'Miscellaneous', amount: 0 },
            ],
            revenue_projections: months.map(m => ({ label: m, revenue: 0 })),
            cashflow_data: months.map(m => ({ label: m, inflow: 0, outflow: 0 })),
        },

        nextStep() {
            if (this.currentStep < 5) this.currentStep++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        prevStep() {
            if (this.currentStep > 1) this.currentStep--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        previewLogo(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => { this.logoPreview = ev.target.result; };
                reader.readAsDataURL(file);
            }
        },
        previewPhotos(e) {
            this.photoPreviews = [];
            const files = Array.from(e.target.files).slice(0, 3);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (ev) => { this.photoPreviews.push(ev.target.result); };
                reader.readAsDataURL(file);
            });
        },

        // Competitors
        addCompetitor() {
            this.form.competitors.push({ name: '', pricing: '', strengths: '', weaknesses: '', threat: 'Medium threat' });
        },
        removeCompetitor(idx) { this.form.competitors.splice(idx, 1); },

        // Team
        addTeamMember() {
            this.form.team_members.push({ name: '', role: '', linkedin: '', bio: '' });
        },
        removeTeamMember(idx) { this.form.team_members.splice(idx, 1); },

        // Milestones
        addMilestone() {
            this.form.milestones.push({ date: '', title: '', description: '' });
        },
        removeMilestone(idx) { this.form.milestones.splice(idx, 1); },

        // Expenses
        addExpense() {
            this.form.monthly_expenses.push({ category: '', amount: 0 });
        },
        removeExpense(idx) { this.form.monthly_expenses.splice(idx, 1); },
    };
}
</script>
@endpush
@endsection
