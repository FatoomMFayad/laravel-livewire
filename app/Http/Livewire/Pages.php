<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Collection;

class Pages extends Component
{
    public $modalFormVisible = false;
    public $slug;
    public $title;
    public $content;

    /**
     *validation rules
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required'
        ];

    }

    /**
     * Runs everytime title input updated
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }
    /**
     *The create function
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVars();
    }

    /**
     * read all pages
     * @return Collection
     */
    public function read()
    {
        return Page::paginate(5);

    }
    /**
     * createShowModal
     * of the create function.
     * @return void
    **/
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }
    /**
     * reset all the properties
     * @return void
     */
    public function resetVars()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }
    /**
     * The Data for the model mapped
     * in this component
     * @return array
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug'=> $this->slug,
            'content' => $this->content
        ];
    }
    /**
     * Generate page slug
     * @return string
     */
    private function generateSlug($value)
    {
        $step1 = str_replace(' ', '-', $value);
        $step2 = strtolower($step1);
        $this->slug = $step2;

    }

    /**
     * The livewire render function
     *
     * @return void
     **/
    public function render()
    {
        return view('livewire.pages',[
            'data' => $this->read(),
        ]);
    }
}
