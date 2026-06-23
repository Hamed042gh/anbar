<div @click.stop x-data="{
    current: 0,
    media: {{ $media->map(fn($m) => $m->getUrl())->toJson() }},
    prev() { this.current = this.current === 0 ? this.media.length - 1 : this.current - 1 },
    next() { this.current = this.current === this.media.length - 1 ? 0 : this.current + 1 },
}" class="select-none" style="padding: 8px">

    <div style="position:relative; width:100%; height:280px; border-radius:16px; overflow:hidden; background:#0f172a">

        <template x-for="(url, i) in media" :key="i">
            <img :src="url"
                 x-show="current === i"
                 x-transition:enter="transition duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover"
            />
        </template>

        <div style="position:absolute; inset:0; background:linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.6))"></div>

        <button @click.stop.prevent="prev"
            style="position:absolute; top:50%; left:10px; transform:translateY(-50%); width:36px; height:36px; background:rgba(0,0,0,0.4); backdrop-filter:blur(6px); border:1.5px solid rgba(255,255,255,0.4); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:10">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <button @click.stop.prevent="next"
            style="position:absolute; top:50%; right:10px; transform:translateY(-50%); width:36px; height:36px; background:rgba(0,0,0,0.4); backdrop-filter:blur(6px); border:1.5px solid rgba(255,255,255,0.4); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:10">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <div style="position:absolute; bottom:12px; left:50%; transform:translateX(-50%); display:flex; gap:6px; align-items:center; z-index:10">
            <template x-for="(_, i) in media" :key="i">
                <div @click.stop="current = i"
                     :style="current === i
                        ? 'width:20px;height:5px;background:white;border-radius:99px;cursor:pointer;transition:all 0.2s'
                        : 'width:5px;height:5px;background:rgba(255,255,255,0.45);border-radius:50%;cursor:pointer;transition:all 0.2s'">
                </div>
            </template>
        </div>
    </div>

    <p style="text-align:center; margin-top:10px; font-size:12px; color:#94a3b8" x-text="`${current + 1} از ${media.length}`"></p>

</div>