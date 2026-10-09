/**
 * BioSfera - Biology Portal Client Logic
 * Smooth scroll reveals, counter numbers animation, interactive quiz,
 * and form interactions.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Intersection Observer for Smooth Scroll Animations
    const animatedElements = document.querySelectorAll('.fade-up, .fade-in, .scale-in');
    
    if ('IntersectionObserver' in window) {
        const appearOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        };

        const appearOnScroll = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, appearOptions);

        animatedElements.forEach(el => appearOnScroll.observe(el));
    } else {
        animatedElements.forEach(el => el.classList.add('visible'));
    }

    // 2. Animated Stats Counters (4000+, 3500+, etc.)
    const counterElements = document.querySelectorAll('.counter-val');
    let countersStarted = false;

    const startCounters = () => {
        counterElements.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
            const duration = 1800; // 1.8 seconds
            const startTime = performance.now();

            const updateCount = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // easeOutQuad
                const easeProgress = 1 - (1 - progress) * (1 - progress);
                const currentVal = Math.floor(easeProgress * target);
                counter.textContent = currentVal.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            requestAnimationFrame(updateCount);
        });
    };

    const statsSection = document.querySelector('.stats-container');
    if (statsSection && 'IntersectionObserver' in window) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !countersStarted) {
                    countersStarted = true;
                    startCounters();
                }
            });
        }, { threshold: 0.3 });
        statsObserver.observe(statsSection);
    } else {
        startCounters();
    }

    // 3. Mobile Navigation Menu Toggle
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const headerNav = document.getElementById('headerNav');
    if (mobileToggle && headerNav) {
        mobileToggle.addEventListener('click', () => {
            headerNav.classList.toggle('mobile-open');
        });
    }

    // 4. Interactive Biology Quiz Logic
    window.checkQuizAnswer = function(button, correctOption, explanationText, feedbackId) {
        const parentList = button.closest('.quiz-options-list');
        const allBtns = parentList.querySelectorAll('.quiz-opt-btn');
        const selected = button.getAttribute('data-option');
        const feedbackEl = document.getElementById(feedbackId);

        // Disable all buttons for this question
        allBtns.forEach(btn => {
            btn.style.pointerEvents = 'none';
            if (btn.getAttribute('data-option') === correctOption) {
                btn.classList.add('correct');
            }
        });

        if (selected === correctOption) {
            button.classList.add('correct');
            if (feedbackEl) {
                feedbackEl.style.display = 'block';
                feedbackEl.style.background = '#dcfce7';
                feedbackEl.style.color = '#166534';
                feedbackEl.innerHTML = `<strong>To'g'ri javob! 🎉</strong> ${explanationText}`;
            }
        } else {
            button.classList.add('wrong');
            if (feedbackEl) {
                feedbackEl.style.display = 'block';
                feedbackEl.style.background = '#fee2e2';
                feedbackEl.style.color = '#991b1b';
                feedbackEl.innerHTML = `<strong>Noto'g'ri!</strong> To'g'ri javob: <strong>${correctOption.toUpperCase()}</strong>. ${explanationText}`;
            }
        }
    };

    // 5. AJAX Inquiries submission handling
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = inquiryForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Yuborilmoqda...';
            submitBtn.disabled = true;

            const formData = new FormData(inquiryForm);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');

            try {
                const response = await fetch(inquiryForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message || 'Arizangiz muvaffaqiyatli qabul qilindi!');
                    inquiryForm.reset();
                } else {
                    showToast('Xatolik yuz berdi. Iltimos ma\'lumotlarni tekshirib qayta yuboring.', 'error');
                }
            } catch (err) {
                showToast('Tarmoq xatosi. Iltimos internetingizni tekshiring.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // 6. Global Toast Notification helper
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = 'toast-alert';
        if (type === 'error') {
            toast.style.background = '#991b1b';
        }
        toast.innerHTML = `<i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'}"></i> <span>${message}</span>`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            toast.style.transition = 'all 0.4s ease';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    };
});
