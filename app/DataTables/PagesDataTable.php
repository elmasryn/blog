<?php

namespace App\DataTables;

use App\Page;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PagesDataTable extends DataTable
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
            ->editColumn('title_en', '{!! str_limit($title_en, 50) !!}')
            ->editColumn('title_ar', '{!! str_limit($title_ar, 50) !!}')
            ->editColumn('body', '{!! str_limit($body, 10) !!}')
            // ->editColumn('status', '{!! $status == 1 ? __("lang.Published") : __("lang.Not Published") !!}')
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw('IF( ? LIKE ? , status = "1", IF( ? LIKE ? , status = "0", False))',
                 [trans("lang.Published") , '%'.$keyword.'%', trans("lang.Not Published") , '%'.$keyword.'%']);
            })
            ->addColumn(
                'show',
                '<a href="{{ url("page/".$slug)}}" target="_blank" class="btn btn-primary btn-sm d-flex flex-nowrap"><i class="fas fa-eye mr-1 my-auto"></i> {{ __("lang.Show") }}</a>'
            )
            ->addColumn(
                'edit',
                '<a href="{{ route(adminview("pages.edit"),$id)}}" class="btn btn-info btn-sm d-flex flex-nowrap"><i class="fas fa-edit mr-1 my-auto"></i> {{ __("lang.Edit") }}</a>'
            )
            ->addColumn(
                'delete',
                'admin.pages_delBtn'
            )
            ->addColumn('checkbox', '<input type="checkbox" name="checked[]" class="item_checkbox" value="{{ $id }}" />')
            ->rawColumns([
                'checkbox', 'show', 'edit', 'delete',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Page $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model)
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
            ->setTableId('pages-table')
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
                ->title(__('lang.Page id')),
            Column::make('title_en')
                ->title(__('lang.Title page name by English')),
            Column::make('title_ar')
                ->title(__('lang.Title page name by Arabic')),
            // Column::make('body')
                // ->title(__('lang.Body')),
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
        return 'Pages_' . date('YmdHis');
    }
}
