<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - نوتیو' : 'نوتیو' }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script data-navigate-once>
    (() => {
        const root = document.documentElement

        const save = () => {
            document.cookie = 'appearance=' + (root.classList.contains('dark') ? 'dark' : 'light')
                + ';path=/;max-age=31536000;samesite=lax'
        }

        save()

        // هر وقت Flux یا کاربر حالت ظاهر را عوض کرد
        new MutationObserver(save).observe(root, { attributes: true, attributeFilter: ['class'] })

        document.addEventListener('livewire:navigated', save)
    })()
</script>
