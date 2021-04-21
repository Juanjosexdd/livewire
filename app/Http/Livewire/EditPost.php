<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    public $open = false;
    public $post, $image, $identificador;
    use WithFileUploads;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->identificador = rand();
    }

    public function save()
    {
        $this->validate();

        if ($this->image)
        {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }
        $this->post->save();
        $this->reset(['open','image']);
        $this->emit('show-post','render');
        $this->emit('alert', 'El Post se actualizó satisfactoriamente');

    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
