@persist('loading-overlay')
<div id="custom-loading-overlay" style="
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(3px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
">
    <div style="
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        background: rgba(30, 41, 59, 0.6);
        padding: 28px 36px;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    ">
        <div style="
            width: 42px;
            height: 42px;
            border: 4px solid rgba(255,255,255,0.2);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: custom-loading-spin 0.7s linear infinite;
        "></div>
        <span style="color: #fff; font-size: 15px; font-weight: 500;">در حال بارگذاری...</span>
    </div>
</div>

<style>
    @keyframes custom-loading-spin {
        to { transform: rotate(360deg); }
    }
</style>

<script>
    if (!window.__loadingOverlayInitialized) {
        window.__loadingOverlayInitialized = true;

        const overlay = document.getElementById('custom-loading-overlay');
        const MIN_DISPLAY_TIME = 400;
        let shownAt = null;

        function showOverlay() {
            shownAt = Date.now();
            overlay.style.visibility = 'visible';
            overlay.style.opacity = '1';
        }

        function hideOverlay() {
            overlay.style.opacity = '0';
            overlay.style.visibility = 'hidden';
        }

        document.addEventListener('livewire:navigating', showOverlay);

        document.addEventListener('livewire:navigated', function () {
            const elapsed = Date.now() - (shownAt || 0);
            const remaining = MIN_DISPLAY_TIME - elapsed;
            remaining > 0 ? setTimeout(hideOverlay, remaining) : hideOverlay();
        });
    }
</script>
@endpersist