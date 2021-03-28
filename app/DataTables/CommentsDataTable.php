<?php

namespace App\DataTables;

use App\Comment;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommentsDataTable extends DataTable
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
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($query) {
                return Carbon::parse($query->updated_at)->format('Y-m-d');
            })
            ->editColumn('body', '{!! str_limit($body, 50) !!}')
            ->editColumn('post', function ($model) {
                return str_limit($model->post->title, 30);
            })
            ->filterColumn('post', function ($query, $keyword) {
                $query->whereHas('post', function ($query) use ($keyword) {
                    $query->whereRaw("title like ?", ["%" . $keyword . "%"]);
                });
            })
            ->editColumn('user', function ($model) {
                if (!is_object($model->user))
                    return $model->name;
                else
                    return '<a href="' . url("profile/" . $model->user->id) . '" target="_blank" >' . $model->name . '</a>';
            })
            ->filterColumn('user', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->whereRaw('name like ?', ["%" . $keyword . "%"]);
                });
            })
            // ->editColumn('status', '{!! $status == 1 ? __("lang.Published") : __("lang.Not Published") !!}')
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereRaw(
                    'IF( ? LIKE ? , status = "1", IF( ? LIKE ? , status = "0", ""))',
                    [trans("lang.Published"), '%' . $keyword . '%', trans("lang.Not Published"), '%' . $keyword . '%']
                );
            })
            ->editColumn('category', function ($model) {
                return $model->post->category->title_en;
            })
            ->filterColumn('category', function ($query, $keyword) {
                $query->whereHas('post.category', function ($query) use ($keyword) {
                    $query->whereRaw("title_en like ?", ["%" . $keyword . "%"]);
                });
            })
            ->addColumn('show', function ($model) {
                return '<a href="' . url("posts/" . $model->post->slug . "#comment" . $model->id) . '" target="_blank" class="btn btn-primary btn-sm d-flex flex-nowrap"><i class="fas fa-eye mr-1 my-auto"></i> ' . __("lang.Show") . '</a>';
            })
            ->addColumn('edit', function ($model) {
                return '<a href="' . url("posts/" . $model->post->slug . "#comment" . $model->id) . '" target="_blank" class="btn btn-info btn-sm d-flex flex-nowrap"><i class="fas fa-edit mr-1 my-auto"></i> ' . __("lang.Edit") . '</a>';
            })
            ->addColumn(
                'delete',
                'admin.comments_delBtn'
            )
            ->addColumn('checkbox', '<input type="checkbox" name="checked[]" class="item_checkbox" value="{{ $id }}" />')
            ->rawColumns([
                'checkbox', 'show', 'edit', 'delete', 'user'
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Comment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Comment $model)
    {
        return $model->newQuery()->with(['user', 'post' => function ($query) {
            $query->withoutGlobalScope('status');
        }])->where(function ($query) {
            if (request()->has('commentPost'))
                return $query->whereHas('post', function ($query) {
                    $query->where('id', request('commentPost'));
                });
            elseif (request()->has('commentUser'))
                return $query->whereHas('user', function ($query) {
                    $query->where('id', request('commentUser'));
                });
        })->selectRaw('comments.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('comments-table')
            ->serverSide(true)
            ->dom('Blfrtip')
            ->lengthMenu([[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, trans('lang.All')]])
            ->minifiedAjax()
            ->orderBy(1)
            ->columns($this->getColumns())
            ->parameters([

                'buttons' => [
                    ['print', 'excel', 'reload'],
                    ['className' => 'delBtn', 'text' => '<i class="fa fa-trash"></i> ' . trans("lang.Delete")]
                ],

                'language' => lang(),

                'initComplete' => "function () {
                    this.api().columns([1,2,3,4,7]).every(function () {
                        var column = this;
                        var input = document.createElement(\"input\");
                        $(input).attr( 'style', 'text-align: center;width: 100%');
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });

                    
                    this.api().columns([5,6]).every( function () {
                        var column = this;
                        var select = $('<select><option value=\"\"></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
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
                ->title(__('lang.Comment id')),
            Column::make('body')
                ->title(__('lang.Body')),
            Column::make('post')
                ->title(__('lang.The post')),
            Column::make('user')
                ->title(__('lang.By')),
            Column::make('status')
                ->title(__('lang.Status')),
            Column::make('category')
                ->title(__('lang.The category')),
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
        return 'Comments_' . date('YmdHis');
    }
}
