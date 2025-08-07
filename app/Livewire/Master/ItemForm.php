<?php

namespace App\Livewire\Master;

use Throwable;
use App\Models\Uom;
use App\Models\Item;
use Livewire\Component;
use App\Models\ItemGroup;
use App\Models\InvoiceItem;
use App\Models\TaxCategory;

class ItemForm extends Component
{
    public ?Item $item = null;
    public $name, $barcode, $is_physical, $has_multi_uom = false, $op_stock_qty, $op_stock_amount, $hsn_sac, $sale_price, $purchase_price, $max_retail_price, $min_sale_price, $self_val_price, $description1, $description2, $description3, $description4, $description5, $min_level_qty, $reorder_level_qty, $max_level_qty;
    public $both_checkboxes;
    public $group_id, $tax_category_id, $uom_id;
    public $groups;
    public $baseUoms;
    public $uoms = [];
    public $taxCategories;
    public bool $isUomLocked = false;
    public function mount(?Item $item = null)
    {
        $this->groups = ItemGroup::all();
        $this->baseUoms = Uom::all();
        $this->taxCategories = TaxCategory::all();

        $this->item = $item;
        $this->isUomLocked = InvoiceItem::where('item_id', $item->id)->exists();

        if ($item && $item->exists) {

            $this->name = $item->name;
            $this->barcode = $item->barcode;
            $this->hsn_sac = $item->hsn_sac;
            $this->sale_price = $item->sale_price;
            $this->purchase_price = $item->purchase_price;
            $this->max_retail_price = $item->max_retail_price;
            $this->min_sale_price = $item->min_sale_price;
            $this->group_id = $item->group_id;
            $this->uom_id = $item->uom_id;
            $this->op_stock_qty = $item->op_stock_qty;
            $this->tax_category_id = $item->tax_category_id;
            $this->has_multi_uom = $item && $item->uoms->isNotEmpty();
            $this->uoms = $this->has_multi_uom
                ? $item->uoms->map(fn($u) => ['uom_id' => $u->uom_id, 'factor' => $u->conversion_factor])->toArray()
                : [];
        } else {
            $this->item = null;
            $this->uoms = [['uom_id' => '', 'factor' => '']];
        }
    }
    public function toggleMultiUom()
    {
        if (!$this->has_multi_uom) {
            $this->uoms = [];
        } elseif (empty($this->uoms)) {
            $this->uoms[] = ['uom_id' => '', 'factor' => ''];
        }
    }
    public function addUom()
    {
        $this->uoms[] = ['uom_id' => '', 'factor' => ''];
    }

    public function removeUom($index)
    {
        unset($this->uoms[$index]);
        $this->uoms = array_values($this->uoms);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string',
            'uom_id' => 'required',
            'op_stock_qty' => [
                'required',
                'numeric',
                'min:0',
            ],
            'has_multi_uom' => 'boolean',
            'hsn_sac' => 'required|numeric',
            'barcode' => 'numeric|nullable',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'max_retail_price' => 'required|numeric',
            'min_sale_price' => 'required|numeric',
            'group_id' => 'required',
            'tax_category_id' => 'required',
        ]);

        if ($this->has_multi_uom) {
            $this->validate(
                [
                    'uoms.*.uom_id' => 'required|exists:uoms,id|different:uom_id',
                    'uoms.*.factor' => 'required|numeric|min:0.0001',
                ],
                [
                    'uoms.*.uom_id.required' => 'Conversion unit is required.',
                    'uoms.*.factor.required' => 'Conversion factor is required.',
                    'uoms.*.factor.min' => 'Conversion factor must be greater than 0.',
                ]
            );
        }

        $item = Item::updateOrCreate(
            ['id' => $this->item?->id],
            $validated
        );

        $item->uoms()->delete();
        if ($this->has_multi_uom) {
            foreach ($this->uoms as $uom) {
                $item->uoms()->create([
                    'uom_id' => $uom['uom_id'],
                    'conversion_factor' => $uom['factor'],
                ]);
            }
        }
        return redirect()->route('item_index');
    }
    public function render()
    {
        return view('livewire.master.item-form');
    }
}
