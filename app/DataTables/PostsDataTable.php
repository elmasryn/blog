<?php

namespace App\DataTables;

use App\Post;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostsDataTable extends DataTable
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
            ->editColumn('title', function ($model) {
                return '<a href=' . adminurl("comments?commentPost=$model->id") . '>' . str_limit($model->title, 50) . '</a>';
            })
            ->editColumn('category', function ($model) {
                return $model->category == null ? "<span class='text-danger'>" . __('lang.Deleted') . "</span>" : $model->category->{'title_' . app()->getLocale()};
            })
            ->filterColumn('category', function ($query, $keyword) {
                if (stristr(__("lang.Deleted"), strip_tags($keyword)))
                    $query->doesntHave('category');
                else
                    $query->whereHas('category', function ($query) use ($keyword) {
                        $query->whereRaw("title_" . app()->getLocale() . " like ?", ["%" . $keyword . "%"]);
                    });
            })
            ->editColumn('user', function ($model) {
                return $model->user == null ? "<span class='text-danger'>" . __('lang.Deleted') . "</span>" :  $model->user->name;
            })
            ->filterColumn('user', function ($query, $keyword) {
                if (stristr(__("lang.Deleted"), strip_tags($keyword)))
                    $query->doesntHave('user');
                else
                    $query->whereHas('user', function ($query) use ($keyword) {
                        $query->whereRaw('name like ?', ["%" . $keyword . "%"]);
                    });
            })
            ->editColumn('tags',  function ($query) {
                if ($query->tags->count() > 0) {
                    $select = '<select class="">';
                    foreach ($query->tags as $tag) {
                        $select .= '<option value="' . $tag->id . '" >' . $tag->name . '</option>';
                    }
                    $select .= '</select>';
                    return $select;
                }
            })
            ->filterColumn('tags', function ($query, $keyword) {
                $query->whereHas('tags', function ($query) use ($keyword) {
                    $query->whereRaw('name like ?', ["%" . $keyword . "%"]);
                });
            })
            ->editColumn('body', '{!! str_limit($body, 10) !!}')
            // ->editColumn('status', '{!! $status == 1 ? __("lang.Published") : __("lang.Not Published") !!}')
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereRaw(
                    'IF( ? LIKE ? , status = "1", IF( ? LIKE ? , status = "0", ""))',
                    [trans("lang.Published"), '%' . $keyword . '%', trans("lang.Not Published"), '%' . $keyword . '%']
                );
            })

            ->addColumn(
                'show',
                '<a href="{{ url("posts/".$slug)}}" target="_blank" class="btn btn-primary btn-sm d-flex flex-nowrap"><i class="fas fa-eye mr-1 my-auto"></i> {{ __("lang.Show") }}</a>'
            )
            ->addColumn(
                'edit',
                '<a href="{{ url("posts/".$slug."/edit")}}" target="_blank" class="btn btn-info btn-sm d-flex flex-nowrap"><i class="fas fa-edit mr-1 my-auto"></i> {{ __("lang.Edit") }}</a>'
            )
            ->addColumn(
                'delete',
                'admin.posts_delBtn'
            )
            ->addColumn('checkbox', '<input type="checkbox" name="checked[]" class="item_checkbox" value="{{ $id }}" />')
            ->rawColumns([
                'checkbox', 'show', 'edit', 'delete', 'user', 'category', 'tags', 'title',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {
        return $model->newQuery()->with('user', 'category', 'tags')->where(function ($query) {
            if (request()->has('postTag'))
                return $query->whereHas('tags', function ($query) {
                    $query->where('id', request('postTag'));
                });
            elseif (request()->has('postCategory'))
                return $query->whereHas('category', function ($query) {
                    $query->where('id', request('postCategory'));
                });
            elseif (request()->has('postUser'))
                return $query->whereHas('user', function ($query) {
                    $query->where('id', request('postUser'));
                });
        })->selectRaw('posts.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('posts-table')
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
                    this.api().columns([1,2,3,4,5,7]).every(function () {
                        var column = this;
                        var input = document.createElement(\"input\");
                        $(input).attr( 'style', 'text-align: center;width: 100%');
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });

                    
                    this.api().columns([6]).every( function () {
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
                ->title(__('lang.Post id')),
            Column::make('title')
                ->title(__('lang.Post title')),
            Column::make('category')
                ->title(__('lang.The Category')),
            Column::make('user')
                ->title(__('lang.By')),
            Column::make('tags')
                ->title(__('lang.The tags')),
            // Column::make('body')
            // ->title(__('lang.Body')),
            // Column::make('slug')
            // ->title(__('lang.Slug')),
            Column::make('status')
                ->title(__('lang.Status')),
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
        return 'Posts_' . date('YmdHis');
    }
}
