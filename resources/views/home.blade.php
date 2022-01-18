@extends('layouts.app')

@section('content')

<div class="container">
   <form action="{{route('url_nalyser')}}" method="POST" id="urlSumition">
      @csrf
      <div class="form-group">
         <label for="urlExampleLabel">URL</label>
         <input type="text" class="form-control" name="url" id="urlTextField" aria-describedby="rulHELP"
            placeholder="Enter URL">
         <small id="showErrorMessage" class="form-text text-muted">Plase past a url for anylizing</small>
      </div>
      <button type="sumit" id="resetSubmitButton" class="btn btn-primary">Submit</button>
   </form>
   <br>
   <section>
      <ul class="list-group" id="renderFetchedData">

      </ul>
   </section>
   <h4>List Of Images</h4>
   <section>
      <ul id="listOfImage">

      </ul>
   </section>
   <h4>List of Interanl Links</h4>
   <section>
      <ul id="listOfExternalLinks">

      </ul>
   </section>
   <h4>List of Exteranl Links</h4>
   <section>
      <ul id="listOfInternalLinks">

      </ul>
   </section>
   <h4>Meta tags with there Discription</h4>
   <section>
      <table class="table">
         <thead id="hideThisFirst">
            <tr>
               <th scope="col">Meta Tags</th>
               <th scope="col">Description</th>
            </tr>
         </thead>
         <tbody>
            <tr id="metaTable">
              
            </tr>
         </tbody>
      </table>
   </section>
</div>
@endsection