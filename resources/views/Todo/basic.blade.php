<script type="text/javascript">
    $('#dg_ref_bagian').datagrid({
        columns: [
            [{
                field: 'id',
                title: 'ID',
                width: 100,
            }, {
                field: 'name',
                title: 'Nama User',
                width: 200,
            }, {
                field: 'todo_name',
                title: 'Todo',
                width: 200,
                sortable: true
            }, {
                field: 'todo_image',
                title: 'Image',
                width: 200,
                formatter: function (value, row, index) {
                    const html =
                        `<a href="${row.todo_image}" data-lightbox="img-lightbox"><img width="100" src="${row.todo_image}"></a>`;
                    return html;
                }
            }]
        ]
    });

    var url_ref_bagian;

    function newData_ref_bagian() {
        $('#dlg_ref_bagian').dialog('open').dialog('setTitle', 'New Data');
        $('#fm_ref_bagian').form('clear');
        url_ref_bagian = '{{ url("api/todo/save") }}';
    }

    function editData_ref_bagian() {
        var row = $('#dg_ref_bagian').datagrid('getSelected');
        console.log(row);
        if (row) {
            $('#dlg_ref_bagian').dialog('open').dialog('setTitle', 'Edit Data');

            $('#fm_ref_bagian').form('load', {
                id: row.id,
                todo_name: row.todo_name
            });

            url_ref_bagian = '{{ url("api/todo/update") }}';
        }
    }

    function saveData_ref_bagian() {
        $('#fm_ref_bagian').form('submit', {
            url: url_ref_bagian,
            onSubmit: function () {
                $.messager.progress({
                    title: 'Please waiting',
                    msg: 'Loading data...'
                });
                return $(this).form('validate');
            },
            success: function (result) {
                if (!_.isNil(result)) {
                    result = JSON.parse(result);
                }

                $.messager.progress('close');
                if (result.status) {
                    $('#dlg_ref_bagian').dialog('close'); // close the dialog
                    $('#dg_ref_bagian').datagrid('reload'); // reload the Data data
                } else {
                    if (!_.isNil(result.message)) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.message
                        });
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: 'Error server'
                        });
                    }

                }
            },
            onLoadSuccess: function () {
                $.messager.progress('close');
            },
            onLoadError: function () {
                $.messager.progress('close');
            },
        });
    }

    function removeData_ref_bagian() {
        var row = $('#dg_ref_bagian').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Confirm', 'Are you sure you want to remove this Data?', function (r) {
                if (r) {
                    $.post('{{ url("api/todo/delete") }}', {
                        id: row.id
                    }, function (result) {
                        if (result.status) {
                            $('#dg_ref_bagian').datagrid('reload'); // reload the Data data
                        } else {
                            $.messager.show({ // show error message
                                title: 'Error',
                                msg: result.message
                            });
                        }
                    }, 'json');
                }
            });
        }
    }

    function doSearch(value, name) {
        // console.log('You input: ' + value+'('+name+')');
        $('#dg_ref_bagian').datagrid('load', {
            [name]: value
        });
    }

    $('#dg_ref_bagian').datagrid({
        onRowContextMenu: function (e) {
            e.preventDefault();
            $('#ingrid_ref_bagian').menu('show', {
                left: e.pageX,
                top: e.pageY
            });
        },
        onDblClickRow: function (e) {
            editData_ref_bagian();
        }
    });

</script>


<!-- FUNGSI KLIK KANAN -->
<div id="ingrid_ref_bagian" class="easyui-menu" style="width:120px;">
    <div data-options="iconCls:'icon-edit'" onclick="editData_ref_bagian()">Edit</div>
    <div data-options="iconCls:'icon-remove'" onclick="removeData_ref_bagian()">Remove</div>
    <div class="menu-sep"></div>
    <div data-options="iconCls:'icon-no'">Cancel</div>
</div>

<!-- FUNGSI TOOL BAR -->
<div id="toolbar_ref_bagian">
    <table width="100%">
        <tr>
            <td style="padding: 5px 10px">
                <div class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newData_ref_bagian()">New</div>
                <div class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editData_ref_bagian()">Edit
                </div>
                <div class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeData_ref_bagian()">
                    Remove</div>
            </td>
            <td style="padding: 5px 10px;text-align:right">
                <input class="easyui-searchbox" data-options="prompt:'Please Input Value',menu:'#mm',searcher:doSearch"
                    style="width:100%">
                <div id="mm">
                    <!-- <div data-options="name:'all', iconCls:'icon-ok'">All News</div> -->
                    <div data-options="name:'filter_todo_name'">Todo Name</div>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- Table -->
<table id="dg_ref_bagian" title="Data Todo" style="width: auto; height: auto;" url="{{ url('api/todo') }}" method="GET"
    toolbar="#toolbar_ref_bagian" pagination="true" pageSize="20" rownumbers="true" fitColumns="true"
    singleSelect="true">
</table>

<div id="dlg_ref_bagian" class="easyui-dialog" modal="true" style="padding:10px 20px" closed="true"
    buttons="#dlg_ref_bagian-buttons">
    <form id="fm_ref_bagian" method="post" enctype="multipart/form-data" novalidate>
        <div style="margin-bottom:20px; display: none;">
            <input name="id" class="easyui-textbox" style="width: 300px;" data-options="label:'Id:'" />
        </div>
        <div style="margin-bottom:20px">
            <input name="todo_name" class="easyui-textbox" style="width: 300px;"
                data-options="label:'Todo:',required : true" />
        </div>
        <div style="margin-bottom:20px">
            <input name="todo_image" class="easyui-filebox" style="width: 300px;" data-options="label:'Todo Image:'" />
        </div>
    </form>
</div>

<div id="dlg_ref_bagian-buttons">
    <div class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData_ref_bagian()">Save</div>
    <div class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_ref_bagian').dialog('close')">
        Cancel</div>
</div>
