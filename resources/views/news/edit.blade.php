@extends('layouts.myapp')
@section('title', 'Edit News')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-800">Edit Post</h1>
        </div>
        
        <form action="{{ route('news.update', $news->id) }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @if($news->status === 'rejected' && $news->admin_note)
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold text-sm">Góp ý từ Admin:</p>
                    <p class="text-sm mt-1">{{ $news->admin_note }}</p>
                </div>
            @endif
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" value="{{ $news->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Cover Image:</label>
                @if($news->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $news->image_path) }}" alt="Current Image" class="h-20 w-auto rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <div class="relative">
                    <select name="category_id" id="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags (comma separated):</label>
                <input type="text" name="tags" id="tags" value="{{ $news->tags->pluck('name')->implode(', ') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                <textarea name="content" id="summernote" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $news->content }}</textarea>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('news.index') }}" class="mr-4 text-gray-600 hover:text-gray-800 font-medium text-sm">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Update Post
                </button>
            </div>
        </form>
    </div>

    <script>
      $('#summernote').summernote({
        placeholder: 'Write your content here...',
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
@endsection