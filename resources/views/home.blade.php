@extends('layouts.app')

@section('content')

<div class="container">
   <form action="{{route('url')}}" method="POST" >
      @csrf
      <div class="form-group">
         <label for="urlExampleLabel">URL</label>
         <input type="hidden" name="csrfToken" value="{{ csrf_token() }}">
         <input type="text" class="form-control" name="url" id="urlTextField" aria-describedby="rulHELP"
            placeholder="Enter URL">
         <small id="rulHELP" class="form-text text-muted">Plase past a url for anylizing</small>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
   </form>
   <br>
    <div id="target" style="height: 200px; width:200px;">

    </div>
   <section>
        <ul class="list-group">
            <li class="list-group-item">Number of Words on the page</li>
            <li class="list-group-item">Number of Characters on the page</li>
            <li class="list-group-item">Number of Images with Image Name</li>
            <li class="list-group-item">Number Internal URLs with List</li>
            <li class="list-group-item">Number External URLs with List</li>
            <li class="list-group-item">Number of Paragraph</li>
            <li class="list-group-item">Number of Embed Video</li>
            <li class="list-group-item">Number of H1/H2/H3/H4/H5/H5</li>
            <li class="list-group-item">Title of the Page</li>
            <li class="list-group-item">Meta Keyword of the page</li>
            <li class="list-group-item">Meta Description of the page</li>
            <li class="list-group-item">Number of Keywords which is matching with "What" "How" "Why" "When" "Where"</li>
        </ul>
   </section>
</div>
@endsection