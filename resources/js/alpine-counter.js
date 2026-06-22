document.addEventListener('alpine:init', () => {
    Alpine.data('counter', (target, decimals = 0) => ({
        value: 0,
        init() {
            const duration = 900;
            const start = performance.now();
            const step = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                this.value = target * eased;
                if (progress < 1) requestAnimationFrame(step);
                else this.value = target;
            };
            requestAnimationFrame(step);
        },
        toFa(str) {
            const fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            return str.replace(/[0-9]/g, d => fa[d]);
        },
        formatted() {
            const str = this.value.toLocaleString('en-US', {
                maximumFractionDigits: decimals,
                minimumFractionDigits: decimals,
            });
            return this.toFa(str);
        },
    }));
});