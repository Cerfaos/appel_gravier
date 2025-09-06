{{--
 Composant Data Table Forest Premium
 Usage: @include('admin.components.data-table', [
 'id' => 'posts-table',
 'columns' => [
 ['key' => 'title', 'label' => 'Titre', 'sortable' => true],
 ['key' => 'category', 'label' => 'Catégorie'],
 ['key' => 'created_at', 'label' => 'Date', 'sortable' => true],
 ['key' => 'actions', 'label' => 'Actions', 'class' => 'text-center']
 ],
 'data' => $posts,
 'actions' => ['edit', 'delete']
 ])
--}}

@php
 $tableId = $id ?? 'data-table-' . uniqid();
 $columns = $columns ?? [];
 $data = $data ?? collect();
 $actions = $actions ?? [];
 $exportable = $exportable ?? false;
@endphp

<div>
 
 <!-- Table Header with Controls -->
 <div>
 <div>
 <h3>
 {{ $title ?? 'Données' }}
 <span>({{ $data->count() }})</span>
 </h3>
 </div>
 
 @if($exportable || isset($createUrl))
 <div>
 @if(isset($createUrl))
 <a href="{{ $createUrl }}">
 <i data-feather="plus"></i>
 {{ $createLabel ?? 'Nouveau' }}
 </a>
 @endif
 
 @if($exportable)
 <div>
 <button type="button" id="export-pdf">
 <i data-feather="file-text"></i>
 PDF
 </button>
 <button type="button" id="export-excel">
 <i data-feather="download"></i>
 Excel
 </button>
 </div>
 @endif
 </div>
 @endif
 </div>
 
 <!-- Table -->
 <div>
 <div>
 <table id="{{ $tableId }}">
 <thead>
 <tr>
 @foreach($columns as $column)
 <th
 @if($column['sortable'] ?? false) data-sortable="true" @endif>
 {{ $column['label'] }}
 @if($column['sortable'] ?? false)
 <i data-feather="chevrons-up-down"></i>
 @endif
 </th>
 @endforeach
 </tr>
 </thead>
 
 <tbody>
 @forelse($data as $row)
 <tr>
 @foreach($columns as $column)
 <td>
 @if($column['key'] === 'actions')
 <div>
 @if(in_array('view', $actions) && method_exists($row, 'getViewUrl'))
 <a href="{{ $row->getViewUrl() }}" 
 
 title="Voir">
 <i data-feather="eye"></i>
 </a>
 @endif
 
 @if(in_array('edit', $actions) && method_exists($row, 'getEditUrl'))
 <a href="{{ $row->getEditUrl() }}" 
 
 title="Modifier">
 <i data-feather="edit"></i>
 </a>
 @endif
 
 @if(in_array('delete', $actions) && method_exists($row, 'getDeleteUrl'))
 <form method="POST" 
 action="{{ $row->getDeleteUrl() }}" 

 onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
 @csrf
 @method('DELETE')
 <button type="submit" 
 
 title="Supprimer">
 <i data-feather="trash-2"></i>
 </button>
 </form>
 @endif
 </div>
 @elseif(isset($column['render']))
 {!! $column['render']($row) !!}
 @else
 {{ data_get($row, $column['key'], '-') }}
 @endif
 </td>
 @endforeach
 </tr>
 @empty
 <tr>
 <td colspan="{{ count($columns) }}">
 <div>
 <div>📄</div>
 <p>{{ $emptyMessage ?? 'Aucune donnée disponible' }}</p>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 </div>
 
 <!-- Table Footer -->
 @if($data instanceof \Illuminate\Contracts\Pagination\Paginator)
 <div>
 <div>
 Affichage de {{ $data->firstItem() ?? 0 }} à {{ $data->lastItem() ?? 0 }} 
 sur {{ $data->total() }} résultats
 </div>
 <div>
 {{ $data->links() }}
 </div>
 </div>
 @endif
 
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
 // Initialiser DataTables si disponible
 if (typeof $.fn.DataTable !== 'undefined') {
 $('#{{ $tableId }}').DataTable({
 responsive: true,
 language: {
 url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
 },
 order: [],
 columnDefs: [
 { orderable: false, targets: 'no-sort' }
 ]
 });
 }
 
 // Gestion des actions de suppression
 document.querySelectorAll('.fp-delete-form').forEach(form => {
 form.addEventListener('submit', function(e) {
 if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
 e.preventDefault();
 }
 });
 });
});
</script>
@endpush