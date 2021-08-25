<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="baseUrl" content="{{ url('/') }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-easyui/themes/default/easyui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-easyui/themes/icon.css') }}">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Laravel Easy Ui Test
            </div>
            <a href="{{ route('todo.basic') }}">Goto Basic Table</a>
            <table id="dg" title="EdiTable" style="width:700px;height:450px" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="id" width="50" editable="false">ID</th>
                        <th field="name" width="50" editable="false">Name</th>
                        <th field="todo_name" width="50" editor="{type:'validatebox',options:{required:true}}">Todo</th>
                    </tr>
                </thead>
            </table>
            <div id="toolbar">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
            </div>



        </div>
    </div>
</body>
<script src="{{ asset('assets/plugins/jquery-easyui/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-easyui/jquery.easyui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-easyui/plugins/jquery.edatagrid.js') }}"></script>


<script>
    var baseUrl = $('meta[name=baseUrl]').attr('content');

    $('#dg').edatagrid({
        // loader: function(param, success, error) {
        //     $.ajax({
        //         type: 'GET',
        //         url: `${baseUrl}/api/todo`,
        //         data: param,
        //         dataType: 'json',
        //         async: false,
        //         success: function(data) {
        //             success(data.data);
        //         },
        //         error: function() {
        //             error.apply(this, arguments);
        //         },
        //         complete: function(jqXHR, textStatus) {}
        //     });
        // },
        url: `${baseUrl}/api/todo`,
        method: 'GET',
        saveUrl: `${baseUrl}/api/todo/save`,
        updateUrl: `${baseUrl}/api/todo/update`,
        destroyUrl: `${baseUrl}/api/todo/delete`,

        onBeforeSave: function(index) {
            // $('#dg').edatagrid('loading'); 
            // $('#dg').edatagrid('reload'); 
        },

        onDestroy: function(index) {
            // console.log(index);
            // $('#dg').edatagrid('loading'); 
            // $('#dg').edatagrid('reload'); 
        },

        onSuccess: function(index,row){
            // console.log(index);
            // console.log(row);
            // $('#dg').edatagrid('loading'); 
            $('#dg').edatagrid('reload'); 
        },

        onSave: function(index) {
            $('#dg').edatagrid('loading'); 
        },
    });
</script>

</html>