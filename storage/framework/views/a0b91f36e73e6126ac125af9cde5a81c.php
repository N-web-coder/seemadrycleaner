<?php $__env->startSection('meta_title', 'Contact Us - ' . config('app.name')); ?>
<?php $__env->startSection('meta_description', 'Have a question? Need a pickup? Get in touch with us through our contact form or visit our main office.'); ?>

<?php $__env->startSection('content'); ?>
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <h5 class="text-primary fw-bold text-uppercase mb-3">Get In Touch</h5>
                    <h1 class="fw-bold mb-4">We'd love to hear from you.</h1>
                    <p class="text-muted mb-5 lead">Whether you have a question about our services, pricing, or need help
                        with an existing order, our team is always here to support you.</p>

                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border d-flex align-items-center">
                        <div class="bg-primary-subtle text-primary rounded-circle p-3 me-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Our Office</h6>
                            <span class="text-muted small"><?php echo e(env('COMPANY_ADDRESS')); ?></span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border d-flex align-items-center">
                        <div class="bg-success-subtle text-success rounded-circle p-3 me-4">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Phone Number</h6>
                            <span class="text-muted small"> <?php echo e(env('COMPANY_PHONE')); ?></span>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border d-flex align-items-center">
                        <div class="bg-info-subtle text-info rounded-circle p-3 me-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email Support</h6>
                            <span class="text-muted small"><?php echo e(env('COMPANY_EMAIL')); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card p-lg-5 p-4 shadow-lg border-0 rounded-5">
                        <h3 class="fw-bold mb-4">Send a Message</h3>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('contact.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-600">Full Name</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-3 rounded-3 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="John Doe" value="<?php echo e(old('name')); ?>" required>
                                    <?php $__errorArgs = ['name'];
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
                                    <label class="form-label fw-600">Email Address</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-3 rounded-3 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="john@example.com" value="<?php echo e(old('email')); ?>" required>
                                    <?php $__errorArgs = ['email'];
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
                                <div class="col-md-12">
                                    <label class="form-label fw-600">Subject</label>
                                    <input type="text" name="subject" class="form-control bg-light border-0 py-3 rounded-3 <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="How can we help?" value="<?php echo e(old('subject')); ?>">
                                    <?php $__errorArgs = ['subject'];
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
                                <div class="col-md-12">
                                    <label class="form-label fw-600">Message</label>
                                    <textarea name="message" class="form-control bg-light border-0 py-3 rounded-3 <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="5"
                                        placeholder="Tell us more about your inquiry..." required><?php echo e(old('message')); ?></textarea>
                                    <?php $__errorArgs = ['message'];
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
                                <div class="col-md-12">
                                    <label class="form-label fw-600">Security Question: What is <?php echo e($num1); ?> + <?php echo e($num2); ?>?</label>
                                    <input type="number" name="captcha" class="form-control bg-light border-0 py-3 rounded-3 <?php $__errorArgs = ['captcha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Enter your answer" required>
                                    <?php $__errorArgs = ['captcha'];
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
                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn btn-primary d-block w-100 py-3 fw-bold shadow-sm rounded-3">Send
                                        Inquiry</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/seemadrycleaner/htdocs/seemadrycleaner.in/resources/views/frontend/contact.blade.php ENDPATH**/ ?>