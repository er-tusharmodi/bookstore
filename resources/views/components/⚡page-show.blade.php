<?php

use App\Models\Page;
use Livewire\Component;

new class extends Component
{
    public string $slug = '';
    public ?Page $page = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->page = Page::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }
};
?>

<main class="page-shell">
    <section class="section reveal">
        <div class="section-head">
            <div>
                <h1 class="section-title">{{ $page->title }}</h1>
                @if ($page->summary)
                    <p class="section-subtitle">{{ $page->summary }}</p>
                @endif
            </div>
        </div>

        <article class="card" style="padding: 1.5rem;">
            {!! $page->body !!}
        </article>
    </section>
</main>