
<h1>Comment</h1>


<form action="{{route('testcomment.store')}}" method="post">
@csrf
    
        <div class="input-group mb-3 col-12">
            <input name="comment" type="text" class="form-control" placeholder="Tweet Comment">


            <div class="input-group-append flex">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </button>
            </div>


        </div>
</form>
