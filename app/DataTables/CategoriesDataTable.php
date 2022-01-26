<?php

namespace App\DataTables;

use App\Category;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
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
            ->editColumn('title_en', function ($model) {
                return '<a href='.adminurl("posts?postCategory=$model->id").'>'. str_limit($model->title_en, 50) .'</a>';
            })
            ->editColumn('title_ar', function ($model) {
                return '<a href='.adminurl("posts?postCategory=$model->id").'>'. str_limit($model->title_ar, 50) .'</a>';
            })
            ->editColumn('desc_en', '{!! str_limit($desc_en, 50) !!}')
            ->editColumn('desc_ar', '{!! str_limit($desc_ar, 50) !!}')
            // ->editColumn('status', '{!! $status == 1 ? __("lang.Published") : __("lang.Not Published") !!}')
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw('IF( ? LIKE ? , status = "1", IF( ? LIKE ? , status = "0", False))',
                 [trans("lang.Published") , '%'.$keyword.'%', trans("lang.Not Published") , '%'.$keyword.'%']);
            })
            ->addColumn(
                'show',
                '<a href="{{ url("posts?category=".$slug)}}" target="_blank" class="btn btn-primary btn-sm d-flex flex-nowrap"><i class="fas fa-eye mr-1 my-auto"></i> {{ __("lang.Show") }}</a>'
            )
            ->addColumn(
                'edit',
                '<a href="{{ route(adminview("categories.edit"),$id)}}" class="btn btn-info btn-sm d-flex flex-nowrap"><i class="fas fa-edit mr-1 my-auto"></i> {{ __("lang.Edit") }}</a>'
            )
            ->addColumn(
                'delete',
                'admin.categories_delBtn'
            )
            ->addColumn('checkbox', '<input type="checkbox" name="checked[]" class="item_checkbox" value="{{ $id }}" />')
            ->rawColumns([
                'checkbox', 'show', 'edit', 'delete','title_en', 'title_ar',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('categories-table')
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
                    this.api().columns([1,2,3,4,6]).every(function () {
                        var column = this;
                        var input = document.createElement(\"input\");
                        $(input).attr( 'style', 'text-align: center;width: 100%');
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });

                    
                    this.api().columns([5]).every( function () {
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
                ->title(__('lang.Category id')),
            Column::make('title_en')
                ->title(__('lang.Title name by English')),
            Column::make('title_ar')
                ->title(__('lang.Title name by Arabic')),
            // Column::make('desc_en')
                // ->title(__('lang.Desc name by English')),
            // Column::make('desc_ar')
                // ->title(__('lang.Desc name by Arabic')),
            Column::make('slug')
                ->title(__('lang.Slug')),
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
        return 'Categories_' . date('YmdHis');
    }
}
