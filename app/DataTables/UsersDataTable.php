<?php

namespace App\DataTables;

use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            // ->editColumn('created_at', function ($query) {
            //     return Carbon::parse($query->created_at)->format('Y-m-d');
            // })
            // ->editColumn('updated_at', function ($query){
            //     return Carbon::parse($query->updated_at)->format('Y-m-d');
            // })
            ->editColumn('name', function ($model) {
                if ($model->posts->count() > 1)
                    return '<a href=' . adminurl("posts?postUser=$model->id") . '>' . str_limit($model->name, 50) . '</a>';
                else 
                    return '<a href=' . adminurl("comments?commentUser=$model->id") . '>' . str_limit($model->name, 50) . '</a>';
            })
            ->editColumn('email', '{!! str_limit($email, 50) !!}')
            ->editColumn('profile', function ($model) {
                return optional($model->profile)->lang == "en" ? __("lang.English") : (optional($model->profile)->lang == "ar" ? __("lang.Arabic") : (optional($model->profile)->lang  == Null ? "<span class='text-danger'>" . __('lang.Without') . "</span>" :
                    ''));
            })

            // comment the below code if working with serverSide(true)
            ->filterColumn('profile', function ($query, $keyword) {
                if (stristr(__("lang.English"), $keyword))
                    $query->whereHas('profile', function ($query) {
                        $query->where('lang', 'en');
                    });
                elseif (stristr(__("lang.Arabic"), $keyword))
                    $query->whereHas('profile', function ($query) {
                        $query->where('lang', 'ar');
                    });
                elseif (stristr(__("lang.Without"), strip_tags($keyword)))
                    $query->whereHas('profile', function ($query) {
                        $query->where('lang', Null);
                    });
            })

            ->addColumn('roles',  function ($query) {
                return $query->roles->map(function ($role) {
                    return $role->name;
                })->implode('<br>');
            })

            // comment the below code if working with serverSide(true)
            ->filterColumn('roles', function ($query, $keyword) {
                if (stristr('Editor', $keyword))
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'Editor');
                    });
                elseif (stristr('User', $keyword))
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'User');
                    });
                elseif (stristr('Admin', $keyword))
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'Admin');
                    });
            })

            ->addColumn(
                'show',
                '<a href="{{ url("profile/".$id)}}" target="_blank" class="btn btn-primary btn-sm d-flex flex-nowrap"><i class="fas fa-eye mr-1 my-auto"></i> {{ __("lang.Show") }}</a>'
            )
            ->addColumn(
                'edit',
                '<a href="{{ route(adminview("users.edit"),$id)}}" class="btn btn-info btn-sm d-flex flex-nowrap"><i class="fas fa-edit mr-1 my-auto"></i> {{ __("lang.Edit") }}</a>'
            )
            ->addColumn(
                'delete',
                'admin.users_delBtn'
            )
            ->addColumn('checkbox', '<input type="checkbox" name="checked[]" class="item_checkbox" value="{{ $id }}" />')
            ->rawColumns([
                'checkbox', 'show', 'edit', 'delete', 'roles', 'profile', 'name',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->with('roles', 'profile', 'posts')
            ->selectRaw('users.*') //>>>>>>> Relation - Belongs To Many + Has one
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->serverSide(true)
            ->dom('Blfrtip')
            ->lengthMenu([[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, trans('lang.All')]])
            ->minifiedAjax()
            ->orderBy(1)
            ->columns($this->getColumns())
            ->parameters([

                'buttons' => [
                    ['create', 'print', 'excel', 'reload'],
                    ['className' => 'delBtn', 'text' => '<i class="fa fa-trash"></i> ' . trans("lang.Delete")]
                ],

                'language' => lang(),

                'initComplete' => "function () {
                    this.api().columns([1,2,3,6]).every(function () {
                        var column = this;
                        var input = document.createElement(\"input\");
                        $(input).attr( 'style', 'text-align: center;width: 100%');
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });

                    
                    this.api().columns([4,5]).every( function () {
                        var column = this;
                        var select = $('<select><option value=\"\"></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    // .search( val ? '^'+val+'$' : '', true, false )
                                    .search( val )
                                    .draw();
                                    
                                
                            } );
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value=\"'+d+'\">'+d+'</option>' )
                        } );
                    } );
                        


                }",

            ]);
    }


    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('checkbox')
                ->title('<input type="checkbox" class="check_all" onclick="check_all()" />')
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false),


            Column::make('id')
                ->title(__('lang.User id')),
            Column::make('name')
                ->title(__('lang.Name')),
            Column::make('email')
                ->title(__('lang.Email')),
            Column::make('roles')
                ->title(__('lang.Role')),
            Column::make('profile')
                ->title(__('lang.Favorite language')),
            Column::make('created_at')
                ->title(__('lang.Created_at')),
            // Column::make('updated_at')
            // ->title(__('lang.Last update')),


            Column::computed('show')
                ->title(__('lang.Show'))
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false),
            Column::computed('edit')
                ->title(__('lang.Edit'))
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false),
            Column::computed('delete')
                ->title(__('lang.Delete'))
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
