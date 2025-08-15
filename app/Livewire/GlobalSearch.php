<?php

namespace App\Livewire;

use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';
    public array $results = [];

    public function updatedQuery($value)
    {
        usleep(300000);
        $this->search();
    }

    private function highlightText($text, $query)
    {
        if (empty($query) || empty($text)) {
            return $text;
        }
        $escapedQuery = preg_quote($query, '/');
        $pattern = "/\\b($escapedQuery)/i";

        return preg_replace($pattern, '<mark class="bg-warning text-dark">$1</mark>', $text);
    }

    public function search()
    {
        $this->results = []; // Clear results at the start

        if (strlen($this->query) < 2) {
            return; // Exit early if query is too short
        }

        $query = $this->query;

        $models = config('globalsearch.models');
        foreach ($models as $modelClass => $meta) {
            $builder = $modelClass::query();

            // Exclude accounts with group_id=32 for Account model
            if ($modelClass === \App\Models\Account::class) {
                $builder->where('group_id', '!=', 32);
            }

            $builder->where(function ($q) use ($meta, $query) {
                foreach ($meta['fields'] as $field) {
                    $q->orWhere($field, 'like', "%$query%");
                }
            });

            $records = $builder->limit(5)->get();
            if ($records->isNotEmpty()) {
                $this->results[] = [
                    'query' => $query,
                    'label' => $meta['label'],
                    'items' => $records->map(function ($record) use ($meta, $query) {
                        $routeParams = [];
                        if (isset($meta['route_params'])) {
                            foreach ($meta['route_params'] as $paramKey => $source) {
                                if (is_numeric($paramKey)) {
                                    $routeParams[] = $record->{$source};
                                } else {
                                    $value = $record->{$source};
                                    $routeParams[$paramKey] = is_object($value) ? $value : $value;
                                }
                            }
                        } else {
                            $routeParams = [$record];
                        }

                        $title = str_contains($meta['title'], '.')
                            ? data_get($record, $meta['title'])
                            : $record->{$meta['title']};

                        if ($meta['subtitle'] === 'created_at') {
                            $subtitle = $record->created_at->format('d M Y');
                        } elseif (str_contains($meta['subtitle'], '.')) {
                            $subtitle = data_get($record, $meta['subtitle']);
                        } else {
                            $subtitle = $record->{$meta['subtitle']};
                        }

                        return [
                            'title' => $this->highlightText($title, $query),
                            'subtitle' => $this->highlightText($subtitle, $query),
                            'query' => $query,
                            'url' => route($meta['route_name'] ?? $meta['route'], $routeParams),
                        ];
                    })->toArray(),
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
