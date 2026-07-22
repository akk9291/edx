
<?php
    $b = is_array($bearing_specs ?? null) ? $bearing_specs : [];
    $val = function (string $key) use ($b): string {
        return old('bearing_specs.'.$key, $b[$key] ?? '');
    };
?>

<div class="card mb-4 border-primary">
    <div class="card-header bg-light">
        <h6 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Bearing catalog &amp; technical data</h6>
        <small class="text-muted d-block mt-1">These values are saved in <strong>specifications</strong> and power the storefront product tabs (Overview, Equivalents, Suffix) and PDF.</small>
    </div>
    <div class="card-body">
        <h6 class="text-secondary text-uppercase small mb-3">Boundary dimensions</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Bore diameter</label>
                <input type="text" name="bearing_specs[bore_diameter]" class="form-control <?php $__errorArgs = ['bearing_specs.bore_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('bore_diameter')); ?>" placeholder="e.g. 15 mm">
                <?php $__errorArgs = ['bearing_specs.bore_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Outside diameter</label>
                <input type="text" name="bearing_specs[outside_diameter]" class="form-control <?php $__errorArgs = ['bearing_specs.outside_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('outside_diameter')); ?>" placeholder="e.g. 32 mm">
                <?php $__errorArgs = ['bearing_specs.outside_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Width</label>
                <input type="text" name="bearing_specs[width]" class="form-control <?php $__errorArgs = ['bearing_specs.width'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('width')); ?>" placeholder="e.g. 8 mm">
                <?php $__errorArgs = ['bearing_specs.width'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Performance</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Basic dynamic load rating</label>
                <input type="text" name="bearing_specs[dynamic_load_rating]" class="form-control <?php $__errorArgs = ['bearing_specs.dynamic_load_rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('dynamic_load_rating')); ?>" placeholder="e.g. 5.60 KN">
                <?php $__errorArgs = ['bearing_specs.dynamic_load_rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Basic static load rating</label>
                <input type="text" name="bearing_specs[static_load_rating]" class="form-control <?php $__errorArgs = ['bearing_specs.static_load_rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('static_load_rating')); ?>" placeholder="e.g. 2.83 KN">
                <?php $__errorArgs = ['bearing_specs.static_load_rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Limiting speed – grease</label>
                <input type="text" name="bearing_specs[limiting_speed_grease]" class="form-control <?php $__errorArgs = ['bearing_specs.limiting_speed_grease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('limiting_speed_grease')); ?>" placeholder="e.g. 22000 r/min">
                <?php $__errorArgs = ['bearing_specs.limiting_speed_grease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Limiting speed – oil</label>
                <input type="text" name="bearing_specs[limiting_speed_oil]" class="form-control <?php $__errorArgs = ['bearing_specs.limiting_speed_oil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('limiting_speed_oil')); ?>" placeholder="e.g. 26000 r/min">
                <?php $__errorArgs = ['bearing_specs.limiting_speed_oil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Properties</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Number of rows</label>
                <input type="text" name="bearing_specs[number_of_rows]" class="form-control <?php $__errorArgs = ['bearing_specs.number_of_rows'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('number_of_rows')); ?>" placeholder="e.g. 1">
                <?php $__errorArgs = ['bearing_specs.number_of_rows'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Bore type</label>
                <input type="text" name="bearing_specs[bore_type]" class="form-control <?php $__errorArgs = ['bearing_specs.bore_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('bore_type')); ?>" placeholder="e.g. Cylindrical">
                <?php $__errorArgs = ['bearing_specs.bore_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cage</label>
                <input type="text" name="bearing_specs[cage]" class="form-control <?php $__errorArgs = ['bearing_specs.cage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('cage')); ?>" placeholder="e.g. Sheet Steel">
                <?php $__errorArgs = ['bearing_specs.cage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Radial internal clearance</label>
                <input type="text" name="bearing_specs[radial_clearance]" class="form-control <?php $__errorArgs = ['bearing_specs.radial_clearance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('radial_clearance')); ?>" placeholder="e.g. CN">
                <?php $__errorArgs = ['bearing_specs.radial_clearance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tolerance class for dimensions</label>
                <input type="text" name="bearing_specs[tolerance_class]" class="form-control <?php $__errorArgs = ['bearing_specs.tolerance_class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('tolerance_class')); ?>" placeholder="e.g. P6">
                <?php $__errorArgs = ['bearing_specs.tolerance_class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Product net weight</label>
                <input type="text" name="bearing_specs[weight]" class="form-control <?php $__errorArgs = ['bearing_specs.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('weight')); ?>" placeholder="e.g. 0.02 kg">
                <?php $__errorArgs = ['bearing_specs.weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Equivalents (manufacturer designations)</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <label class="form-label">SKF</label>
                <input type="text" name="bearing_specs[equiv_skf]" class="form-control <?php $__errorArgs = ['bearing_specs.equiv_skf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('equiv_skf')); ?>" placeholder="Model / ref.">
                <?php $__errorArgs = ['bearing_specs.equiv_skf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">FAG</label>
                <input type="text" name="bearing_specs[equiv_fag]" class="form-control <?php $__errorArgs = ['bearing_specs.equiv_fag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('equiv_fag')); ?>" placeholder="Model / ref.">
                <?php $__errorArgs = ['bearing_specs.equiv_fag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">NTN</label>
                <input type="text" name="bearing_specs[equiv_ntn]" class="form-control <?php $__errorArgs = ['bearing_specs.equiv_ntn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('equiv_ntn')); ?>" placeholder="Model / ref.">
                <?php $__errorArgs = ['bearing_specs.equiv_ntn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">Timken</label>
                <input type="text" name="bearing_specs[equiv_timken]" class="form-control <?php $__errorArgs = ['bearing_specs.equiv_timken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($val('equiv_timken')); ?>" placeholder="Model / ref.">
                <?php $__errorArgs = ['bearing_specs.equiv_timken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Suffix &amp; description</h6>
        <p class="small text-muted mb-2">Add one or more rows (suffix / field name and description). Shown on the product page &quot;Suffix description&quot; tab.</p>
        <?php
            $suffixPairs = $bearing_specs['suffix_pairs'] ?? [];
            if (! is_array($suffixPairs) || count($suffixPairs) === 0) {
                $suffixPairs = [['suffix' => '', 'description' => '']];
            }
        ?>
        <div id="suffix-pairs-container" class="border rounded p-3 bg-light">
            <?php $__currentLoopData = $suffixPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spIdx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="suffix-pair-row row g-3 mb-3 align-items-end pb-3 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>" data-index="<?php echo e($spIdx); ?>">
                    <div class="col-md-4">
                        <label class="form-label">Suffix / field</label>
                        <input type="text"
                               name="bearing_specs[suffix_pairs][<?php echo e($spIdx); ?>][suffix]"
                               data-suffix-field="suffix"
                               class="form-control <?php $__errorArgs = ['bearing_specs.suffix_pairs.'.$spIdx.'.suffix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('bearing_specs.suffix_pairs.'.$spIdx.'.suffix', $pair['suffix'] ?? '')); ?>"
                               placeholder="e.g. 2RS, C3">
                        <?php $__errorArgs = ['bearing_specs.suffix_pairs.'.$spIdx.'.suffix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text"
                               name="bearing_specs[suffix_pairs][<?php echo e($spIdx); ?>][description]"
                               data-suffix-field="description"
                               class="form-control <?php $__errorArgs = ['bearing_specs.suffix_pairs.'.$spIdx.'.description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('bearing_specs.suffix_pairs.'.$spIdx.'.description', $pair['description'] ?? '')); ?>"
                               placeholder="e.g. Rubber seals on both sides">
                        <?php $__errorArgs = ['bearing_specs.suffix_pairs.'.$spIdx.'.description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-2 d-flex gap-1 flex-wrap">
                        <button type="button" class="btn btn-sm btn-success add-suffix-pair" title="Add row"><i class="bi bi-plus-lg"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-suffix-pair" title="Remove row"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php $__errorArgs = ['bearing_specs.suffix_pairs'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('suffix-pairs-container');
        if (!container) return;
        var suffixPairIndex = <?php echo e(count($suffixPairs)); ?>;

        function reindexSuffixRows() {
            var rows = container.querySelectorAll('.suffix-pair-row');
            rows.forEach(function (row, i) {
                row.setAttribute('data-index', String(i));
                row.querySelectorAll('input[data-suffix-field]').forEach(function (inp) {
                    var field = inp.getAttribute('data-suffix-field');
                    if (field) {
                        inp.name = 'bearing_specs[suffix_pairs][' + i + '][' + field + ']';
                    }
                });
            });
            rows.forEach(function (row, i) {
                if (i < rows.length - 1) {
                    row.classList.add('border-bottom', 'pb-3');
                } else {
                    row.classList.remove('border-bottom', 'pb-3');
                }
            });
        }

        function updateSuffixRemoveButtons() {
            var rows = container.querySelectorAll('.suffix-pair-row');
            container.querySelectorAll('.remove-suffix-pair').forEach(function (btn) {
                btn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            });
        }

        container.addEventListener('click', function (e) {
            if (e.target.closest('.add-suffix-pair')) {
                var row = e.target.closest('.suffix-pair-row');
                var clone = row.cloneNode(true);
                clone.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
                clone.classList.add('border-bottom', 'pb-3', 'mb-3');
                container.appendChild(clone);
                suffixPairIndex++;
                reindexSuffixRows();
                updateSuffixRemoveButtons();
            } else if (e.target.closest('.remove-suffix-pair')) {
                var rows = container.querySelectorAll('.suffix-pair-row');
                if (rows.length <= 1) return;
                e.target.closest('.suffix-pair-row').remove();
                reindexSuffixRows();
                updateSuffixRemoveButtons();
            }
        });
        updateSuffixRemoveButtons();
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH F:\laragon\www\edx\resources\views/admin/products/partials/bearing-spec-form.blade.php ENDPATH**/ ?>