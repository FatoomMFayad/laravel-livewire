<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Collection;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;
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
     * Update function
     * @return void
     */
    public function update()
    {
        $this->validate();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;

    }

    /**
     * delete function
     * @return void
     */

    public function delete()
    {
        Page::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
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
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }

    /**
     * Update function
     * @param $id
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    /**
     * Shows the delete confirmation modal
     *@param $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
        $this->loadModel();

    }

    /**
     * Load data of the model
     * for this component
     *
     */
    public function loadModel()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }

    /**
     * reset pagination
     * @return void
     */

    public function mount()
    {
        $this->resetPage();
    }
    /**
     * reset all the properties
     * @return void
     */
    public function resetVars()
    {
        $this->modelId = null;
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
