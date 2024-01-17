
@extends("admin.layout")


@section("style")


    <style>
        .list{
            opacity: 0;
            transform: translateY(-200px);
            max-height: 0px;
            transition: all 1s ease-out,max-height 1.5s ease-out;
            overflow: hidden;   
        }
        .max-height{
            max-height: 700px;
        }

        .list.show{
            opacity: 1;
            max-height: 700px;
            transform: translateY(0);
        }
    </style>
@endsection

@section("content")
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <h1 class="text-center uppercase font-bold text-5xl mb-5">Questions</h1>
    @if(session('role') == 'it' || session('role') == 'bph')
    <div class="select w-1/2 mx-auto">
        <select id="division" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="none" selected>Choose Division</option>

            @foreach ($divisions as $d)
                @if($d['slug'] == "bph")
                    @continue;
                @endif
                <option value="{{ $d['id'] }}"> {{ $d['name'] }} </option>
            @endforeach
        </select>
    </div>
    @endif
</div>
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8 invisible" id="canvas">
    <div class="container-input px-8 w-full">

    </div>

    <div class="w-1/2 mx-auto">
        <div class="flex justify-end">
            <button id="add" class="w-full invisible bg-green-500 hover:bg-green-600 text-white rounded-lg px-3 py-2 mt-3 mb-5">Add Question +</button>
        </div>
    </div> 
</div>


@endsection

@section("script")
<script>
    $(document).ready(function(){
        var i = 0;
        function add(){
            $("#add").off("click");
            $("#add").click(function(){
                i++;
                $(".container-input").append(`
                <div class="max-height list field-input w-full pb-4 pt-2 rounded-2xl mx-auto mt-3 mb-5">
                    <div class="close-button flex justify-end mb-5 ">
                        <strong class="text-4xl px-2 mr-2 hover:text-[2.5rem] absolute cursor-pointer alert-del">&times;</strong>
                    </div>
                    <div class="box-pertanyaan w-[80%] mx-auto ">
                        <label for="question`+i+`" class="text-xl mb-3">Pertanyaan `+i+`: </label>
                        <textarea name="" id="question`+i+`" rows="10" class="border-2 py-2 pl-4 w-full rounded-lg shadow-xl mb-3"></textarea>
                        <label for="deskirpsi`+i+`" class="text-xl mb-3">Deskripsi: </label>
                        <textarea name="" id="deskirpsi`+i+`" rows="5" class="border-2 py-2 pl-4 w-full  rounded-lg mb-3"></textarea>
                    <div class="flex justify-center">
                        <button id="submit`+i+`" class="submitting bg-green-500 hover:bg-green-600 text-white rounded-lg px-5 py-2 mt-2 w-1/2" w-full>Submit</button>
                    </div>
                </div>`);
                
                setTimeout(() => {
                $(".container-input :last-child").addClass("show");
                $(".container-input :last-child").removeClass("max-height");
                }, 200);

                $("#question"+i).focus();

                //disabled and hide add button
                    $("#add").attr("disabled", true);
                    $("#add").addClass("invisible");
                
                submitForm();
                deleteForm();
            });
        }
        add();

        function changeNomer(){
            var index = 1;
            i = 0;
            $(".field-input").each(function(){
                $(this).find("label").eq(0).text("Pertanyaan "+index+": ");
                i=index;
                index++;
                
            });
        }  

        function getQuestionByDivision(division){
            $.ajax({
                url:  "{{ route('admin.question.get') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "division_id": division,
                } ,
                success: function(res){
                    i=0;
                    $(".field-input").remove();
                    for(var j = 0; j < res.length; j++){
                        i++;
                        $(".container-input").append(`
                        <div id="`+res[j].id+`" class="show list field-input w-full pb-4 pt-2 rounded-2xl mx-auto mt-3 mb-5">
                            <div class="close-button flex justify-end mb-5 ">
                                <strong class="text-4xl px-2 mr-2 hover:text-[2.5rem] absolute cursor-pointer alert-del">&times;</strong>
                            </div>
                            <div class="box-pertanyaan w-[80%] mx-auto ">
                                <label for="question`+i+`" class="text-xl mb-3">Pertanyaan `+i+`: </label>
                                <textarea name="" id="question`+i+`" rows="10" class="border-2 py-2 pl-4 w-full rounded-lg shadow-xl mb-5"></textarea>
                                <label for="deskirpsi`+i+`" class="text-xl mb-3">Deskripsi: </label>
                                <textarea name="" id="deskirpsi`+i+`" rows="5" class="border-2 py-2 pl-4 w-full mb-5 rounded-lg"></textarea>
                            </div>
                        </div>`);
                        $("#question"+i).val(res[j].question);
                        $("#deskirpsi"+i).val(res[j].description);
                    }
                    add();
                    deleteForm();
                    updateForm();
                    //restore kondisi awal supaya tombol add nya ada
                    $("#add").attr("disabled", false);
                    $('#add').removeClass("invisible");

                },
                error: function(err){
                    $(".field-input").remove();
                    $("#add").attr("disabled", true);
                    $('#add').addClass("invisible");
                    Swal.fire('Error', 'Gagal Pengambilan Data', 'error');
                }
            })
        }

        
        $("#division").on('change',function(){
            if($(this).val() == "none"){
                $(".field-input").remove();
                $("#add").attr("disabled", true);
                $('#add').addClass("invisible");
                $('#canvas').addClass("invisible");
                return;
            }
            $('#canvas').removeClass("invisible");
            getQuestionByDivision($(this).val());
        })

        function submitForm(){
            $(".submitting").off("click");
            $(".submitting").click(function(){
                var question = $(this).parent().parent().find("textarea").eq(0).val();
                var description = $(this).parent().parent().find("textarea").eq(1).val();
                var division_id = $('#division').val();
                $this = $(this);
                if(question == "" || description == ""){
                    Swal.fire('Error', 'Pertanyaan dan Deskripsi tidak boleh kosong', 'error');
                    return;
                }
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                        $.ajax({
                        url:  "{{ route('admin.question.add') }}",
                        method: "POST",
                        dataType: 'json', 
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "question": question,
                            "description": description,
                            "division_id": division_id,
                        } ,
                        success: function(res){
                            if(res.success){
                                $this.parent().parent().parent().attr("id", res.id);
                                $this.remove();
                                $("#add").attr("disabled", false);
                                $('#add').removeClass("invisible");
                                Swal.close();
                                Swal.fire('Success', 'Berhasil Submit Question', 'success');
                                updateForm();
                            }else{
                                Swal.fire('Error','Gagal Input Question','error')
                            }
                            
                        },
                        error: function(err){
                            Swal.close();
                            Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                        }
                        })
                    }

                });
            })
        }

        function deleteForm(){
                //on delete
                $(".alert-del").off("click");
                $(".alert-del").click(function(){
                    const field= $(this).parent().parent();
                    Swal.fire({
                        title : "Are You Sure?",
                        text : "Setelah dihapus, pertanyaan tidak dapat dikembalikan lagi",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText : "Delete !",
                    }).then((result) => {
                        if(result.isConfirmed){
                            //check ga boleh hapus form yang belum pernah di submit
                            if(field.attr("id") == null){
                                Swal.fire("Error", "Dilarang Menghapus Pertanyaan yang belum di submit\n \"pertanyaan ini belum tersimpan\" ", "error")
                                return;
                            }

                            var id = field.attr("id")
                            $.ajax({
                                url:  "{{ route('admin.question.delete') }}",
                                method: "post",
                                // dataType: 'json',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "question_id": id ,
                                } ,
                                success: function(res){
                                    Swal.fire('Success', 'Berhasil Hapus Pertanyaan', 'success');

                                    field.removeClass("show pb-4 pt-2");
                                    setTimeout(() => {
                                        field.remove();
                                        changeNomer();
                                    }, 1600);
                                },
                                error: function(err){
                                    Swal.fire('Error', 'Gagal Menghapus Data' , 'error');
                                }
                            })                           
                        }
                    })
                    
                });
        }

        function updateForm(){
            $("textarea").off("change");
            $("textarea").on('change',function(){
                var question = $(this).parent().find("textarea").eq(0).val();
                var description = $(this).parent().find("textarea").eq(1).val();
                var division_id = $('#divisions').val();
                var id = $(this).parent().parent().attr("id");
                var self = $(this);
                if(question == "" || description == ""){
                    Swal.fire('Error', 'Pertanyaan dan Deskripsi tidak boleh kosong', 'error');
                    if(!self.next().hasClass("msg-error")){
                        self.after("<p class='msg-error text-sm text-red-600 mb-2'> Gagal Menyimpan Perubahan. </p>");
                    }
                    return;
                }
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                        $.ajax({
                            url:  "{{ route('admin.question.update') }}",
                            method: "POST",
                        dataType: 'json', 
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "question": question,
                            "description": description,
                            "question_id": id,
                        } ,
                        success: function(res){
                            if(res.success){
                                Swal.close();
                                Swal.fire('Success', 'Berhasil Update', 'success');
                                self.parent().find('.msg-error').remove();
                            }else{
                                Swal.fire('Error','Gagal Update Question','error')
                                if(!self.next().hasClass("msg-error")){
                                    self.after("<p class='msg-error text-sm text-red-600 mb-2'> Gagal Menyimpan Perubahan. </p>");
                                }

                            }
                            
                        },
                        error: function(err){
                            Swal.close();
                            if(!self.next().hasClass("msg-error")){
                                self.after("<p class='msg-error text-sm text-red-600 mb-2'> Gagal Menyimpan Perubahan. </p>");
                            }
                            Swal.fire('Error', 'Gagal menghubungi server', 'error');
                        }
                        })
                    }
                    
                });
            })
        }
        
        @if(session('role') != 'bph')
            $('#canvas').removeClass("invisible");
            getQuestionByDivision('{{ session('division_id') }}')
        @endif
    })
</script>
@endsection