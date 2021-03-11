<?php
function show($status,$messages,$data=[]){
    return [
        'status'=>$status,
        'messages'=>$messages,
        'data'=>$data
    ];
}
