<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;

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
     * The livewire render function
     *
     * @return void
     **/
    public function render()
    {
        return view('livewire.pages');
    }
}
