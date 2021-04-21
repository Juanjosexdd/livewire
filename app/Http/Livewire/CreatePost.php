<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = false;

    public $title, $content, $image;

    protected $rules = [
        'title' => 'required|max:50',
        'content' => 'required|max:500',
        'image' => 'required|image|max:2048'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function save()
    {

        $this->validate();
        $image = $this->image->store('posts');
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image'=> $image
        ]);

        $this->reset(['open', 'title', 'content', 'image']);

        $this->emit('render');
        $this->emit('alert', 'El Post se creo satisfactoriamente');
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}
