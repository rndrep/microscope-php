<x-admin-index title="Минералы" :hrefCreate="route('minerals.create')" :model="'minerals'" :fields="$fields"
    :items="$items" />


<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3>{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <a href="{{ $hrefCreate }}" class="btn btn-success">Добавить</a>
                            </div>
                            <div class="dataTables_wrapper">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table
                                            class="table table-responsive table-bordered table-hover dataTable text-center">
                                            <thead>
                                                <tr>
                                                    <th>Действия</th>
                                                    <th>ID</th>
                                                    @foreach($fields as $field)
                                                    <th>{{$field->getCaption()}}</th>
                                                    @endforeach
                                                    <th>Сингония</th>
                                                    <th>Спайность</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $item)
                                                <tr>
                                                    <div class="btn">
                                                        <a href="{{ route($model . '.edit', $item->id) }}"
                                                            class="admin-icon edit-icon"></a>
                                                    </div>
                                                    <td>{{$item->id}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>