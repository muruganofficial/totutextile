<?php

namespace App\Livewire\Shop;

use App\Models\Faq;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.shop')]
class Faqs extends Component
{
    public string $search = '';

    public function render()
    {
        $query = Faq::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
            });
        }

        $faqs = $query->get()->groupBy('category');

        return view('livewire.shop.faqs', [
            'faqGroups' => $faqs
        ]);
    }
}
