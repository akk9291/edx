@extends('layouts.frontend')

@section('title', $title . ' - EDX Rulmenti Romania')

@section('styles')
<style>
    .industry-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 30px;
    }
    .industry-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 30px;
        transition: all 0.3s;
    }
    .industry-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-color: #E31E24;
    }
    .industry-icon {
        width: 50px;
        height: 50px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .industry-icon i {
        font-size: 24px;
        color: #E31E24;
    }
    .industry-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 10px;
    }
    .industry-card p {
        font-size: 13px;
        color: #666;
        margin: 0;
    }
    @media (max-width: 1024px) {
        .industry-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .industry-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">{{ $title }}</div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">{{ $title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<section class="lg:py-20 md:py-14 py-10">
    <div class="container">
        @if($page == 'edx-world')
            <div class="heading3 mb-6">About EDX Rulmenți</div>
            <p class="text-secondary mb-4">EDX Rulmenți is a leading supplier of premium quality ball bearings and industrial components. With years of experience in the industry, we have established ourselves as a trusted partner for businesses across various sectors.</p>
            
            <div class="heading5 mt-8 mb-4">Our Mission</div>
            <p class="text-secondary mb-4">To provide high-quality bearing solutions that meet the demanding requirements of modern industry while maintaining competitive pricing and excellent customer service.</p>
            
            <div class="heading5 mt-8 mb-4">Our Vision</div>
            <p class="text-secondary mb-4">To become the preferred bearing supplier in the region, known for quality, reliability, and technical expertise.</p>
            
            <div class="heading5 mt-8 mb-4">Our Values</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li><strong>Quality:</strong> We never compromise on the quality of our products</li>
                <li><strong>Integrity:</strong> We conduct business with honesty and transparency</li>
                <li><strong>Customer Focus:</strong> Our customers' success is our success</li>
                <li><strong>Innovation:</strong> We continuously improve our products and services</li>
            </ul>
            
        @elseif($page == 'quality-path')
            <div class="heading3 mb-6">Quality Assurance</div>
            <p class="text-secondary mb-4">At EDX Rulmenți, quality is not just a standard – it's our commitment. Every product that leaves our facility undergoes rigorous testing and inspection to ensure it meets the highest industry standards.</p>
            
            <div class="heading5 mt-8 mb-4">Our Quality Process</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li><strong>Material Selection:</strong> We source only premium-grade materials from certified suppliers</li>
                <li><strong>Manufacturing:</strong> State-of-the-art production facilities with precision machinery</li>
                <li><strong>Testing:</strong> Comprehensive testing including dimensional accuracy, hardness, and performance</li>
                <li><strong>Certification:</strong> All products are certified to meet international standards</li>
            </ul>
            
            <div class="heading5 mt-8 mb-4">Certifications</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li>ISO 9001:2015 Quality Management System</li>
                <li>ISO 14001:2015 Environmental Management</li>
                <li>IATF 16949 Automotive Quality Standard</li>
            </ul>
            
        @elseif($page == 'industries')
            <div class="heading3 mb-6">Industries We Serve</div>
            <p class="text-secondary mb-4">EDX Rulmenți provides bearing solutions for a wide range of industries. Our products are designed to meet the specific requirements of each sector.</p>
            
            <div class="industry-grid">
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-car"></i>
                    </div>
                    <h3>Automotive</h3>
                    <p>Bearings for engines, transmissions, and wheel assemblies</p>
                </div>
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-plant"></i>
                    </div>
                    <h3>Agriculture</h3>
                    <p>Durable bearings for farming equipment and machinery</p>
                </div>
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-hard-hat"></i>
                    </div>
                    <h3>Mining</h3>
                    <p>Heavy-duty bearings for mining and extraction equipment</p>
                </div>
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-buildings"></i>
                    </div>
                    <h3>Construction</h3>
                    <p>Reliable bearings for construction machinery</p>
                </div>
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-gear"></i>
                    </div>
                    <h3>Manufacturing</h3>
                    <p>Precision bearings for industrial machinery</p>
                </div>
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="ph ph-lightning"></i>
                    </div>
                    <h3>Energy</h3>
                    <p>Bearings for wind turbines and power generation</p>
                </div>
            </div>
            
        @elseif($page == 'applications')
            <div class="heading3 mb-6">Applications</div>
            <p class="text-secondary mb-4">Our bearings are used in countless applications across various industries. Here are some common applications for our products:</p>
            
            <div class="heading5 mt-8 mb-4">Rotating Equipment</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li>Electric motors and generators</li>
                <li>Pumps and compressors</li>
                <li>Fans and blowers</li>
                <li>Gearboxes and reducers</li>
            </ul>
            
            <div class="heading5 mt-8 mb-4">Transportation</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li>Wheel hubs and axles</li>
                <li>Transmissions</li>
                <li>Steering systems</li>
                <li>Railway applications</li>
            </ul>
            
            <div class="heading5 mt-8 mb-4">Heavy Machinery</div>
            <ul class="list-disc list-inside text-secondary space-y-2">
                <li>Excavators and loaders</li>
                <li>Cranes and hoists</li>
                <li>Conveyor systems</li>
                <li>Rolling mills</li>
            </ul>
        @else
            <p class="text-secondary">Content coming soon...</p>
        @endif
    </div>
</section>
@endsection
