<div id="custom-loading-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <span style="color:white; font-size:24px;">در حال بارگذاری...</span>
</div>

<script>
    window.addEventListener('livewire:navigating', function () {
        document.getElementById('custom-loading-overlay').style.display = 'flex';
    });

    window.addEventListener('livewire:navigated', function () {
        document.getElementById('custom-loading-overlay').style.display = 'none';
    });
</script>