@extends('layouts.app')

@section('title', ($config['product_name'] ?? 'Customize') . ' | Perch')

@section('content')
@php
  $engrOn = !empty($config['has_engraving']);
  $engrCatMode = !empty($config['engraving_category_mode']);
  $stepTotal = (int) ($config['customize_max_step'] ?? 5);
@endphp
<style>
.customize-page{font-family:'Inter',sans-serif;background:#f4f4f2;color:#161616;padding:20px 14px;min-height:72vh}
.customize-page .modal{max-width:1240px;margin:0 auto;background:#fff;border:1px solid #e8e8e8;border-radius:20px;overflow:hidden;box-shadow:0 10px 45px rgba(0,0,0,.08)}
.customize-page .top-nav{display:flex;align-items:center;gap:14px;padding:14px 18px;border-bottom:1px solid #ececec;background:#fbfbfb}
.customize-page .nav-steps{display:flex;align-items:center;gap:8px;overflow-x:auto;flex:1;scrollbar-width:thin}
.customize-page .nav-step{font-size:13px;padding:8px 12px;border-radius:999px;border:1px solid #ddd;background:#fff;color:#666;cursor:pointer;white-space:nowrap;transition:.15s}
.customize-page .nav-step.active{background:#161616;color:#fff;border-color:#161616}
.customize-page .nav-step.done:not(.active){color:#222;border-color:#bbb}
.customize-page .nav-right{display:flex;align-items:center;gap:10px}
.customize-page .nav-cart-wrap{display:flex;flex-direction:column;align-items:flex-end;gap:3px}
.customize-page .add-cart-btn{background:#161616;color:#fff;border:none;border-radius:10px;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer}
.customize-page .add-cart-btn:hover{background:#2c2c2c}
.customize-page .add-cart-btn:disabled{opacity:.65;cursor:not-allowed}
.customize-page .customize-checkout-btn{font-size:13px;font-weight:600;color:#161616;text-decoration:none;padding:10px 16px;border:1px solid #161616;border-radius:10px;background:#fff;white-space:nowrap;display:inline-block}
.customize-page .customize-checkout-btn:hover{background:#f0f0ee}
.customize-page button.customize-checkout-btn{font:inherit;line-height:inherit;cursor:pointer}
.customize-page .customize-checkout-btn:disabled{opacity:.65;cursor:not-allowed}
.customize-page .nav-cart-actions{display:flex;flex-wrap:wrap;gap:8px;justify-content:flex-end;align-items:center}
.customize-page .price-hint{font-size:11px;color:#8a8a8a;text-align:right}
.customize-page .close-btn{width:34px;height:34px;border:1px solid #ddd;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#777;background:#fff}
.customize-page .close-btn:hover{color:#111;border-color:#bdbdbd}
.customize-page .content{display:flex;min-height:660px}
.customize-page .left-col{flex:0 0 57%;padding:18px;border-right:1px solid #ececec;background:#f9f9f7;display:flex;flex-direction:column;position:relative}
.customize-page .bottle-title{font-size:18px;font-weight:700;margin-bottom:12px}
.customize-page #three-wrap{position:relative;flex:1;min-height:420px;background:#efefeb;border:1px solid #e2e2dc;border-radius:14px;display:flex;align-items:center;justify-content:center}
.customize-page #three-wrap canvas{display:block;border-radius:14px}
.customize-page .loading-msg{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;background:#efefeb;border-radius:14px;z-index:10}
.customize-page .spinner{width:34px;height:34px;border:3px solid #ddd;border-top-color:#161616;border-radius:50%;animation:customize-spin .8s linear infinite}
.customize-page .loading-text{font-size:12px;color:#7b7b7b}
.customize-page .view-controls{position:absolute;left:10px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:8px;z-index:5}
.customize-page .view-btn{width:34px;height:34px;border:1px solid #d9d9d9;background:#fff;border-radius:8px;font-size:14px;cursor:pointer}
.customize-page .side-wish{position:absolute;right:10px;top:10px;z-index:5}
.customize-page .wish-btn{width:34px;height:34px;border:1px solid #d9d9d9;border-radius:8px;background:#fff;font-size:18px;color:#c4c4c4;cursor:pointer}
.customize-page .wish-btn.active{color:#e14565}
.customize-page .hint-label{position:absolute;bottom:10px;right:12px;font-size:11px;color:#8a8a8a}
.customize-page .bottom-links{display:flex;gap:16px;margin-top:10px}
.customize-page .bottom-link{font-size:12px;color:#161616;text-decoration:underline;text-underline-offset:3px}
.customize-page .bottom-note{font-size:11px;color:#8a8a8a;margin-top:6px}
.customize-page .right-col{flex:1;padding:22px;display:flex;flex-direction:column;overflow-y:auto}
.customize-page .step-panel{display:none;flex-direction:column;flex:1}
.customize-page .step-panel.active{display:flex}
.customize-page .step-heading{font-size:24px;font-weight:700}
.customize-page .step-counter{font-size:12px;color:#8a8a8a;margin-top:3px}
.customize-page .step-subtext{font-size:13px;color:#666;margin:8px 0 16px}
.customize-page .size-cards{display:flex;flex-direction:column;gap:10px;margin-bottom:16px}
.customize-page .size-static-text{border:1px solid #e8e8e8;border-radius:12px;padding:14px 16px;background:#fafafa;margin-bottom:16px}
.customize-page .size-static-text .static-size-name{font-size:15px;font-weight:700;margin:0 0 4px}
.customize-page .size-static-text .static-size-desc{font-size:12px;color:#7c7c7c;margin:0}
.customize-page .size-static-text .static-size-price{font-size:14px;font-weight:600;margin:8px 0 0}
.customize-page .size-card{display:flex;align-items:center;gap:12px;border:1px solid #ddd;border-radius:12px;padding:12px;cursor:pointer;background:#fff;transition:.15s}
.customize-page .size-card.selected{border-color:#161616;box-shadow:0 0 0 1px #161616 inset}
.customize-page .option-card{display:flex;align-items:center;gap:12px;border:1px solid #ddd;border-radius:12px;padding:12px;background:#fff;margin-bottom:16px}
.customize-page .option-thumb{width:44px;height:44px;border-radius:10px;background:#f2f2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.customize-page .option-thumb svg{width:28px;height:28px}
.customize-page .option-info{flex:1}
.customize-page .option-name{font-size:14px;font-weight:700}
.customize-page .option-desc{font-size:12px;color:#7c7c7c}
.customize-page .option-price{font-size:14px;font-weight:700}
.customize-page .color-label{font-size:13px;color:#666;margin-bottom:8px}
.customize-page .color-row{display:flex;align-items:center;gap:8px}
.customize-page .color-arrow{width:30px;height:30px;border:1px solid #ddd;border-radius:50%;background:#fff;color:#777;cursor:pointer}
.customize-page .swatches-track{display:flex;gap:8px;align-items:center;overflow:hidden;flex:1;padding:5px}
.customize-page .swatch{width:34px;height:34px;border-radius:50%;border:2px solid transparent;cursor:pointer;position:relative}
.customize-page .swatch.selected{border-color:#161616}
.customize-page .swatch.out-of-stock{opacity:.55;cursor:not-allowed}
.customize-page .swatch.out-of-stock::after{content:'';position:absolute;inset:0;border-radius:50%;background:linear-gradient(135deg,transparent 46%,#bdbdbd 46%,#bdbdbd 54%,transparent 54%)}
.customize-page .color-name-label{font-size:12px;color:#777;margin:6px 0 4px;text-align:center;min-height:16px}
.customize-page .bottom-nav{display:flex;gap:10px;justify-content:flex-end;align-items:center;flex-wrap:wrap;margin-top:auto;padding-top:14px}
.customize-page .prev-btn,.customize-page .next-btn{border-radius:10px;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer}
.customize-page .prev-btn{background:#fff;border:1px solid #161616;color:#161616}
.customize-page .next-btn{background:#161616;border:1px solid #161616;color:#fff}
.customize-page .qty-select{padding:9px 12px;border:1px solid #ccc;border-radius:8px;background:#fff}
.customize-page .customize-engraving-block{margin-top:1.25rem;padding:14px 16px;border:1px solid #e2e2dc;border-radius:12px;background:#fafaf8}
.customize-page .engraving-label{font-size:14px;font-weight:600;color:#161616;margin-bottom:6px}
.customize-page .engraving-hint{font-size:12px;color:#666;margin:0 0 10px;line-height:1.45}
.customize-page .engraving-check-wrap{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;margin-bottom:8px;cursor:pointer}
.customize-page .engraving-check-wrap input{width:16px;height:16px;accent-color:#161616}
.customize-page .engraving-textarea{width:100%;padding:10px 12px;border:1px solid #ccc;border-radius:8px;font-size:14px;font-family:inherit;resize:vertical;min-height:52px;box-sizing:border-box}
.customize-page .engraving-textarea:disabled{opacity:.55;background:#f0f0ee}
/* Hydro-style: single column list, full-width cards */
.customize-page .engraving-card-list{display:flex;flex-direction:column;gap:12px;margin-top:12px;max-height:min(52vh,520px);overflow-y:auto;padding:2px 6px 8px 2px;scrollbar-width:thin}
.customize-page .engraving-card-list::-webkit-scrollbar{width:6px}
.customize-page .engraving-card-list::-webkit-scrollbar-thumb{background:#d8d8d8;border-radius:6px}
.customize-page .engraving-card{display:flex;align-items:center;gap:16px;border:1px solid #e0e0e0;border-radius:14px;padding:14px 16px;background:#fff;cursor:pointer;text-align:left;transition:.15s .05s; width:100%;font:inherit;min-height:76px;box-sizing:border-box;box-shadow:0 1px 2px rgba(0,0,0,.04)}
.customize-page .engraving-card:hover{border-color:#c8c8c8;background:#fafafa;box-shadow:0 2px 10px rgba(0,0,0,.07)}
.customize-page .engraving-card.selected{border-color:#161616;background:#fff;box-shadow:0 0 0 1px #161616 inset,0 2px 8px rgba(0,0,0,.06)}
.customize-page .engraving-card-thumb{width:56px;height:56px;border-radius:12px;background:#f3f3f1;flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #ececec}
.customize-page .engraving-card-thumb img{width:100%;height:100%;object-fit:cover}
.customize-page .engraving-thumb-placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:1px;line-height:1.05;font-weight:800;font-size:7px;letter-spacing:.06em;color:#6a6a6a;background:linear-gradient(180deg,#ececea 0%,#e0e0dc 100%);width:100%;height:100%;border-radius:11px;box-sizing:border-box;padding:4px 2px;text-transform:uppercase;font-family:inherit}
.customize-page .engraving-thumb-placeholder span{display:block}
.customize-page .engraving-thumb-placeholder.is-simple{background:#f0f0ee;font-size:20px;color:#b5b5b5;letter-spacing:0}
.customize-page .engraving-card-body{flex:1;min-width:0;padding-right:4px}
.customize-page .engraving-card-title{font-size:15px;font-weight:700;color:#161616;line-height:1.25}
.customize-page .engraving-card-price{font-size:14px;font-weight:600;color:#4a4a4a;margin-top:4px}
.customize-page .engraving-card-chev{color:#b0b0b0;font-size:20px;flex-shrink:0;font-weight:300;line-height:1}
.customize-page .engraving-step .step-heading{font-size:22px;letter-spacing:-.02em}
.customize-page .engraving-step .step-subtext{color:#6b6b6b;line-height:1.5;max-width:36rem}
.customize-page .engraving-mode-row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:10px;flex-wrap:wrap}
.customize-page .engraving-mode-row .mode-title{font-size:14px;font-weight:700;color:#161616}
.customize-page .engraving-mode-toggles{display:flex;align-items:center;gap:16px}
.customize-page .engraving-radio{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#161616;cursor:pointer;user-select:none}
.customize-page .engraving-radio input{width:16px;height:16px;accent-color:#161616}
.customize-page .engraving-slot-row{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap}
.customize-page .engraving-slot-btn{flex:1;min-width:160px;display:flex;align-items:center;gap:10px;border:1px solid #e0e0e0;border-radius:12px;background:#fff;padding:12px 14px;cursor:pointer;font:inherit;transition:.15s}
.customize-page .engraving-slot-btn:hover{background:#fafafa;border-color:#c8c8c8}
.customize-page .engraving-slot-btn.active{border-color:#161616;box-shadow:0 0 0 1px #161616 inset}
.customize-page .engraving-slot-dot{width:30px;height:30px;border-radius:999px;background:#f0f0ee;border:1px solid #e6e6e6;display:flex;align-items:center;justify-content:center;color:#666;font-weight:800;flex-shrink:0}
.customize-page .engraving-slot-btn.active .engraving-slot-dot{background:#161616;color:#fff;border-color:#161616}
.customize-page .engraving-slot-label{font-size:14px;font-weight:700;color:#161616}
.customize-page .engraving-slot-sub{font-size:12px;color:#777;margin-top:2px}
.customize-page .engraving-slot-text{display:flex;flex-direction:column;min-width:0}
.customize-page .engraving-slot-summary{font-size:12px;color:#666;margin-top:8px}
.customize-page .engraving-slot-summary strong{color:#161616}
.customize-page .engraving-detail-back{background:none;border:none;padding:0;font-size:13px;color:#161616;text-decoration:underline;cursor:pointer;margin-bottom:12px}
.customize-page .engraving-detail-title{font-size:16px;font-weight:700;margin-bottom:8px}
.customize-page .engraving-file-input{display:block;width:100%;max-width:100%;margin:12px 0;padding:10px 12px;font-size:14px;border:1px solid #c8c8c8;border-radius:10px;background:#fff;box-sizing:border-box;min-height:46px;cursor:pointer}
.customize-page .engraving-upload-label{display:block;font-size:13px;font-weight:600;color:#333;margin-top:4px}
.customize-page .flow-hint{font-size:12px;color:#8a8a8a;margin-top:8px}
@keyframes customize-spin{to{transform:rotate(360deg)}}
@media(max-width:980px){
  .customize-page .content{flex-direction:column}
  .customize-page .left-col{flex:0 0 auto;border-right:none;border-bottom:1px solid #ececec}
  .customize-page #three-wrap{min-height:320px}
  .customize-page .top-nav{flex-wrap:wrap;gap:10px;padding:12px 14px}
  .customize-page .nav-steps{order:2;width:100%;flex:none;padding-bottom:4px}
  .customize-page .nav-right{order:1;width:100%;justify-content:space-between}
  .customize-page .nav-cart-wrap{flex-direction:row;align-items:center;gap:10px;flex-wrap:wrap}
  .customize-page .nav-cart-actions{width:100%}
  .customize-page .add-cart-btn,.customize-page .customize-checkout-btn{flex:1;text-align:center}
}
@media(max-width:480px){
  .customize-page .nav-step{font-size:11px;padding:6px 10px}
  .customize-page .add-cart-btn,.customize-page .customize-checkout-btn{font-size:12px;padding:8px 12px}
}
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="customize-page">
  <div class="modal">
    <div class="top-nav">
      <div class="nav-steps">
        <div class="nav-step active" data-step="1" onclick="goTo(1)">Body</div>
        <div class="nav-step" data-step="2" onclick="goTo(2)">Cap</div>
        <div class="nav-step" data-step="3" onclick="goTo(3)">Straw</div>
        <div class="nav-step" data-step="4" onclick="goTo(4)">Handle</div>
        <div class="nav-step" data-step="5" onclick="goTo(5)">Bottom Base</div>
        @if($engrOn && $engrCatMode)
        <div class="nav-step" data-step="6" onclick="goTo(6)">Engraving</div>
        @endif
      </div>
      <div class="nav-right">
        <div class="nav-cart-wrap">
          <div class="nav-cart-actions">
            <button type="button" class="add-cart-btn" id="top-cart-btn" onclick="addToCart()">Add to Cart – {{ $config['currency'] }}{{ number_format($config['base_price'], 2) }}</button>
            <button type="button" class="customize-checkout-btn" onclick="buyItNow()">Buy it now</button>
          </div>
          <span class="price-hint" id="price-hint"></span>
        </div>
        <a href="{{ route('home') }}" class="close-btn" title="Close">✕</a>
      </div>
    </div>
    <div class="content">
      <div class="left-col">
        <div class="bottle-title">{{ $config['product_name'] ?? 'Customize' }}</div>
        <div id="three-wrap">
          <div class="loading-msg" id="loading-msg">
            <div class="spinner"></div>
            <div class="loading-text">Loading 3D model…</div>
          </div>
          <div class="view-controls">
            <button class="view-btn" title="Reset" onclick="resetCam()">⟳</button>
            <button class="view-btn" title="Zoom in" onclick="zoomIn()">＋</button>
            <button class="view-btn" title="Zoom out" onclick="zoomOut()">－</button>
          </div>
          <div class="side-wish">
            <button class="wish-btn" id="wish-btn" onclick="toggleWish()">♡</button>
          </div>
          <div class="hint-label">Drag to rotate · Scroll to zoom · Preview shows all parts; use tabs to change each</div>
        </div>
        <div class="bottom-links">
          <button type="button" class="bottom-link" style="background:none;border:none;padding:0;font:inherit;" onclick="shareCustomizeDesign()">↑ Share link</button>
          <button type="button" class="bottom-link" style="background:none;border:none;padding:0;font:inherit;" onclick="startOverCustomize()">↺ Start over</button>
        </div>
        <div class="bottom-note">Please be aware that customized products are not eligible for returns.</div>
      </div>
      <div class="right-col">
        <!-- Step 1: Tumbler -->
        <div class="step-panel active" id="panel-1">
          <div class="step-heading">Body</div>
          <div class="step-counter">1 of {{ $stepTotal }}</div>
          <div class="step-subtext">Main tumbler body ka color yahan set karein. Baaki marked parts next steps me milenge.</div>
          <div class="size-cards" id="size-cards">
            @php
              $sz = $config['sizes'] ?? [];
              $sizeCount = count($sz);
              $lastIdx = $sizeCount ? $sizeCount - 1 : 0;
            @endphp
            @if($sizeCount <= 1)
              @php $s0 = $sz[0] ?? ['name' => '', 'desc' => '', 'price' => null]; @endphp
              <div class="size-static-text" id="size-static-only" data-size-idx="0" aria-live="polite">
                @if(!empty($s0['name']))
                  <p class="static-size-name">{{ $s0['name'] }}</p>
                @endif
                @if(!empty($s0['desc']))
                  <p class="static-size-desc">{{ $s0['desc'] }}</p>
                @endif
                @if(isset($s0['price']) && $s0['price'] !== '' && $s0['price'] !== null)
                  <p class="static-size-price">{{ $config['currency'] }}{{ number_format((float) $s0['price'], 2) }}</p>
                @endif
              </div>
            @else
              @foreach($sz as $i => $size)
              <div class="size-card {{ $i === $lastIdx ? 'selected' : '' }}" data-size-idx="{{ $i }}" onclick="selectSize({{ $i }})">
                <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><rect x="6" y="14" width="18" height="38" rx="1" fill="#222"/><path d="M7 14 Q4 18 3 24 L27 24 Q26 18 23 14Z" fill="#444"/><rect x="9" y="8" width="12" height="8" rx="2" fill="#555"/></svg></div>
                <div class="option-info"><div class="option-name">{{ $size['name'] ?? '40 oz' }}</div><div class="option-desc">{{ $size['desc'] ?? 'Large insulated tumbler with handle and straw.' }}</div></div>
                @if(!empty($size['price']))
                <div class="option-price">{{ $config['currency'] }}{{ number_format($size['price'], 2) }}</div>
                @endif
              </div>
              @endforeach
            @endif
          </div>
          <div class="color-label">Choose color for Body</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('bottle',-1)">&#8249;</button>
            <div class="swatches-track" id="bottle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('bottle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="bottle-color-label">{{ ($config['bottle_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav"><button class="next-btn" onclick="goTo(2)">Next – Cap</button></div>
          <p class="flow-hint">Tip: complete each step left to right, or jump using the tabs above. Your 3D preview updates live.</p>
        </div>

        <!-- Step 2: Cap -->
        <div class="step-panel" id="panel-2">
          <div class="step-heading">Cap</div>
          <div class="step-counter">2 of {{ $stepTotal }}</div>
          <div class="step-subtext">Top cap aur uske neeche wale ring dono ka color yahan set hota hai.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="11" stroke="#222" stroke-width="2"/><path d="M15 4 Q22 4 22 12" stroke="#555" stroke-width="3.5" fill="none" stroke-linecap="round"/></svg></div>
            <div class="option-info"><div class="option-name">Cap</div><div class="option-desc">Straw opening ke around upper cap; neeche wala ring bhi isi color me match hoga.</div></div>
          </div>
          <div class="color-label">Choose color for Cap</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('cap',-1)">&#8249;</button>
            <div class="swatches-track" id="cap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('cap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="cap-color-label">{{ ($config['cap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(1)">Previous – Body</button>
            <button class="next-btn" onclick="goTo(3)">Next – Straw</button>
          </div>
        </div>

        <!-- Step 3: Straw -->
        <div class="step-panel" id="panel-3">
          <div class="step-heading">Straw</div>
          <div class="step-counter">3 of {{ $stepTotal }}</div>
          <div class="step-subtext">Marked straw ka color yahan change hoga.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><path d="M8 26 Q8 6 15 6 Q22 6 22 26" stroke="#222" stroke-width="4" stroke-linecap="round" fill="none"/></svg></div>
            <div class="option-info"><div class="option-name">Silicone Tumbler Straw</div><div class="option-desc">Soft, flexible straw.</div></div>
          </div>
          <div class="color-label">Choose color for Straw</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('strap',-1)">&#8249;</button>
            <div class="swatches-track" id="strap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('strap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="strap-color-label">{{ ($config['strap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(2)">Previous – Cap</button>
            <button class="next-btn" onclick="goTo(4)">Next – Handle</button>
          </div>
        </div>

        <!-- Step 4: Handle -->
        <div class="step-panel" id="panel-4">
          <div class="step-heading">Handle</div>
          <div class="step-counter">4 of {{ $stepTotal }}</div>
          <div class="step-subtext">Side handle ka color alag set karein.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><path d="M22 8 Q28 8 28 18 L28 48 Q28 56 22 56 Q16 56 16 48 L16 18 Q16 8 22 8Z" stroke="#222" stroke-width="2.2" fill="#e8e8e8"/></svg></div>
            <div class="option-info"><div class="option-name">Side Handle</div><div class="option-desc">Bottle side grip handle color.</div></div>
          </div>
          <div class="color-label">Choose color for Handle</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('handle',-1)">&#8249;</button>
            <div class="swatches-track" id="handle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('handle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="handle-color-label">{{ ($config['handle_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(3)">Previous – Straw</button>
            <button class="next-btn" onclick="goTo(5)">Next – Bottom Base</button>
          </div>
        </div>

        <!-- Step 5: Bottom Base -->
        <div class="step-panel" id="panel-5">
          <div class="step-heading">Bottom Base</div>
          <div class="step-counter">5 of {{ $stepTotal }}</div>
          <div class="step-subtext">Neeche ka base/boot ring color yahan alag se set karein (image ke bottom marked area).</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><path d="M5 47 H25 V55 H5 Z" stroke="#222" stroke-width="2" fill="#e8e8e8"/></svg></div>
            <div class="option-info"><div class="option-name">Bottom Base Ring</div><div class="option-desc">Protective base/boot color.</div></div>
          </div>
          <div class="color-label">Choose color for Bottom Base</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('boot',-1)">&#8249;</button>
            <div class="swatches-track" id="boot-swatches"></div>
            <button class="color-arrow" onclick="shiftS('boot',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="boot-color-label">{{ ($config['boot_colors'][0]['name'] ?? 'Lavender') }}</div>
          @if($engrOn && !$engrCatMode)
          <div class="customize-engraving-block" id="customize-engraving-wrap">
            <div class="engraving-label">{{ $config['engraving_label'] ?? 'Engraving' }}</div>
            @php $engrP = (float) ($config['engraving_price'] ?? 0); @endphp
            <p class="engraving-hint">Optional.@if($engrP > 0) Add {{ $config['currency'] ?? '₹' }}{{ number_format($engrP, 2) }} when you enter text.@endif Max {{ (int) ($config['engraving_max_chars'] ?? 40) }} characters.</p>
            <label class="engraving-check-wrap"><input type="checkbox" id="customize-engraving-check" autocomplete="off"> <span>Add engraving</span></label>
            <textarea id="customize-engraving-text" class="engraving-textarea" rows="2" maxlength="{{ (int) ($config['engraving_max_chars'] ?? 40) }}" placeholder="e.g. your name" autocomplete="off"></textarea>
          </div>
          @endif
          <div class="bottom-nav">
            <button type="button" class="prev-btn" onclick="goTo(4)">Previous – Handle</button>
            @if($engrOn && $engrCatMode)
            <button type="button" class="next-btn" onclick="goTo(6)">Next – Engraving</button>
            @else
            <select class="qty-select" id="customize-qty" title="Quantity" onchange="onCustomizeQtyChange(this)"><option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
            <button type="button" class="next-btn" onclick="addToCart()">Add to Cart – <span id="final-price">{{ $config['currency'] }}{{ number_format($config['base_price'], 2) }}</span></button>
            <button type="button" class="customize-checkout-btn" onclick="buyItNow()">Buy it now</button>
            @endif
          </div>
        </div>

        @if($engrOn && $engrCatMode)
        <div class="step-panel engraving-step" id="panel-6">
          <div class="step-heading">{{ $config['engraving_label'] ?? 'Add Engraving' }}</div>
          <div class="step-counter">6 of {{ $stepTotal }}</div>
          <div class="step-subtext">Pick a style below. Each option has its own price and opens the next step when needed. You can skip engraving or go back to change colors.</div>
          <div class="engraving-mode-row">
            <div class="mode-title">Add Engraving</div>
            <div class="engraving-mode-toggles" role="radiogroup" aria-label="Engraving mode">
              <label class="engraving-radio"><input type="radio" name="engr_mode" id="engr-mode-single" value="single" checked> <span>Single</span></label>
              <label class="engraving-radio"><input type="radio" name="engr_mode" id="engr-mode-double" value="double"> <span>Double</span></label>
            </div>
          </div>
          <div class="engraving-slot-row">
            <button type="button" class="engraving-slot-btn active" id="engr-slot-top" data-slot="top">
              <span class="engraving-slot-dot">+</span>
              <span class="engraving-slot-text">
                <span class="engraving-slot-label">Top Box</span>
                <span class="engraving-slot-sub" id="engr-slot-top-sub">Choose option</span>
              </span>
            </button>
            <button type="button" class="engraving-slot-btn" id="engr-slot-bottom" data-slot="bottom" style="opacity:.55" disabled>
              <span class="engraving-slot-dot">+</span>
              <span class="engraving-slot-text">
                <span class="engraving-slot-label">Bottom Box</span>
                <span class="engraving-slot-sub" id="engr-slot-bottom-sub">Double mode only</span>
              </span>
            </button>
          </div>
          <div id="engraving-grid-view">
            <div class="engraving-card-list" id="engraving-card-grid"></div>
          </div>
          <div id="engraving-detail-view" style="display:none">
            <button type="button" class="engraving-detail-back" id="engraving-detail-back">← Back to options</button>
            <div class="engraving-detail-title" id="engraving-detail-title"></div>
            <div id="engraving-detail-body"></div>
          </div>
          <div class="engraving-slot-summary" id="engraving-slot-summary" style="display:none"></div>
          <div class="bottom-nav">
            <button type="button" class="prev-btn" onclick="goTo(5)">Previous – Bottom Base</button>
            <select class="qty-select" id="customize-qty" title="Quantity" onchange="onCustomizeQtyChange(this)"><option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
            <button type="button" class="next-btn" onclick="addToCart()">Add to Cart – <span id="final-price-engr">{{ $config['currency'] }}{{ number_format($config['base_price'], 2) }}</span></button>
            <button type="button" class="customize-checkout-btn" onclick="buyItNow()">Buy it now</button>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
@php
    $customizeAppPath = public_path('assets/js/customize-app.js');
    $customizeAppV = is_readable($customizeAppPath) ? filemtime($customizeAppPath) : (int) time();
@endphp
<script>window.CUSTOMIZE_CHECKOUT_URL = @json(route('checkout.index'));</script>
<script>window.CUSTOMIZE_CONFIG = @json($config);</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ route('customize.app.js', ['v' => $customizeAppV]) }}"></script>
@endpush
