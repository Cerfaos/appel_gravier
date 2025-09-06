{{--
 Ultra Data Table Component
 Usage: @include('admin.components.ultra-data-table', [
   'title' => 'Table Title',
   'subtitle' => 'Table description',
   'headers' => ['Name', 'Email', 'Status', 'Actions'],
   'data' => $data,
   'searchable' => true,
   'sortable' => true,
   'pagination' => true,
   'actions' => ['edit', 'delete'],
   'filters' => ['status' => ['active', 'inactive']]
 ])
--}}

@php
  $title = $title ?? '';
  $subtitle = $subtitle ?? '';
  $headers = $headers ?? [];
  $data = $data ?? collect();
  $searchable = $searchable ?? true;
  $sortable = $sortable ?? true;
  $pagination = $pagination ?? false;
  $actions = $actions ?? [];
  $filters = $filters ?? [];
  $exportable = $exportable ?? false;
  $selectable = $selectable ?? false;
  $tableId = $tableId ?? 'ultra-table-' . uniqid();
@endphp

<div class="ultra-card" data-table-id="{{ $tableId }}">
  
  <!-- Table Header -->
  @if($title || $subtitle || $searchable || $exportable || !empty($filters))
  <div class="ultra-card-header">
    <div class="table-header-left">
      @if($title)
      <h3 class="ultra-card-title">{{ $title }}</h3>
      @endif
      @if($subtitle)
      <p class="table-subtitle">{{ $subtitle }}</p>
      @endif
    </div>
    
    <div class="table-header-right">
      <!-- Filters -->
      @if(!empty($filters))
      <div class="table-filters">
        @foreach($filters as $filterKey => $filterOptions)
        <select class="ultra-form-input table-filter" data-filter="{{ $filterKey }}" style="min-width: 120px;">
          <option value="">Tous {{ ucfirst($filterKey) }}</option>
          @foreach($filterOptions as $option)
          <option value="{{ $option }}">{{ ucfirst($option) }}</option>
          @endforeach
        </select>
        @endforeach
      </div>
      @endif
      
      <!-- Search -->
      @if($searchable)
      <div class="table-search">
        <div class="global-search" style="position: relative;">
          <div class="global-search-icon">
            <i data-feather="search"></i>
          </div>
          <input 
            type="text" 
            class="global-search-input table-search-input"
            placeholder="Rechercher..."
            style="width: 250px;"
          >
        </div>
      </div>
      @endif
      
      <!-- Export Button -->
      @if($exportable)
      <div class="table-export">
        <button class="ultra-btn ultra-btn-secondary ultra-btn-sm" onclick="exportTable('{{ $tableId }}')">
          <i data-feather="download"></i>
          Export
        </button>
      </div>
      @endif
    </div>
  </div>
  @endif
  
  <!-- Table Container -->
  <div class="ultra-card-body" style="padding: 0;">
    <div class="table-container">
      <table class="ultra-table" id="{{ $tableId }}">
        
        <!-- Table Head -->
        <thead>
          <tr>
            @if($selectable)
            <th style="width: 50px;">
              <label class="table-checkbox">
                <input type="checkbox" class="select-all-checkbox">
                <span class="checkbox-mark"></span>
              </label>
            </th>
            @endif
            
            @foreach($headers as $index => $header)
            <th class="{{ $sortable ? 'sortable' : '' }}" data-column="{{ $index }}">
              <div class="table-header-content">
                <span>{{ is_array($header) ? $header['label'] : $header }}</span>
                @if($sortable)
                <div class="sort-arrows">
                  <i data-feather="chevron-up" class="sort-arrow sort-asc"></i>
                  <i data-feather="chevron-down" class="sort-arrow sort-desc"></i>
                </div>
                @endif
              </div>
            </th>
            @endforeach
            
            @if(!empty($actions))
            <th style="width: 100px; text-align: center;">Actions</th>
            @endif
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          @forelse($data as $row)
          <tr class="table-row" data-row-id="{{ $row->id ?? $loop->index }}">
            @if($selectable)
            <td>
              <label class="table-checkbox">
                <input type="checkbox" class="row-checkbox" value="{{ $row->id ?? $loop->index }}">
                <span class="checkbox-mark"></span>
              </label>
            </td>
            @endif
            
            @foreach($headers as $index => $header)
            <td>
              @if(is_array($header) && isset($header['render']))
                {!! $header['render']($row) !!}
              @else
                @php
                  $field = is_array($header) ? $header['field'] : strtolower(str_replace(' ', '_', $header));
                  $value = data_get($row, $field, '—');
                @endphp
                
                @if(is_array($header) && isset($header['type']))
                  @switch($header['type'])
                    @case('badge')
                      <span class="ultra-badge ultra-badge-{{ $value === 'active' ? 'success' : 'error' }}">
                        {{ ucfirst($value) }}
                      </span>
                      @break
                    @case('date')
                      {{ $value instanceof \Carbon\Carbon ? $value->format('d/m/Y H:i') : $value }}
                      @break
                    @case('image')
                      @if($value && $value !== '—')
                      <img src="{{ $value }}" alt="Image" class="table-image" style="width: 40px; height: 40px; border-radius: var(--radius); object-fit: cover;">
                      @else
                      <div class="table-image-placeholder">
                        <i data-feather="image"></i>
                      </div>
                      @endif
                      @break
                    @default
                      {{ $value }}
                  @endswitch
                @else
                  {{ $value }}
                @endif
              @endif
            </td>
            @endforeach
            
            @if(!empty($actions))
            <td class="table-actions">
              <div class="action-buttons">
                @foreach($actions as $action)
                  @if($action === 'edit')
                  <button class="action-btn edit-btn" data-id="{{ $row->id ?? $loop->index }}" title="Modifier">
                    <i data-feather="edit-2"></i>
                  </button>
                  @elseif($action === 'view')
                  <button class="action-btn view-btn" data-id="{{ $row->id ?? $loop->index }}" title="Voir">
                    <i data-feather="eye"></i>
                  </button>
                  @elseif($action === 'delete')
                  <button class="action-btn delete-btn" data-id="{{ $row->id ?? $loop->index }}" title="Supprimer">
                    <i data-feather="trash-2"></i>
                  </button>
                  @elseif(is_array($action))
                  <button class="action-btn {{ $action['class'] ?? '' }}" 
                          data-id="{{ $row->id ?? $loop->index }}"
                          @if(isset($action['url'])) onclick="window.location.href='{{ str_replace(':id', $row->id ?? $loop->index, $action['url']) }}'" @endif
                          title="{{ $action['title'] ?? '' }}">
                    <i data-feather="{{ $action['icon'] ?? 'more-horizontal' }}"></i>
                  </button>
                  @endif
                @endforeach
              </div>
            </td>
            @endif
          </tr>
          @empty
          <tr class="empty-state">
            <td colspan="{{ count($headers) + ($selectable ? 1 : 0) + (!empty($actions) ? 1 : 0) }}" style="text-align: center; padding: var(--space-16);">
              <div class="empty-state-content">
                <div class="empty-state-icon">
                  <i data-feather="database" style="width: 48px; height: 48px; color: var(--cerfaos-text-muted);"></i>
                </div>
                <h4 style="color: var(--cerfaos-text-primary); margin: var(--space-4) 0 var(--space-2);">Aucune donnée</h4>
                <p style="color: var(--cerfaos-text-muted);">Il n'y a actuellement aucun élément à afficher.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
        
      </table>
    </div>
    
    <!-- Table Footer -->
    @if($selectable || $pagination)
    <div class="table-footer">
      @if($selectable)
      <div class="table-selection-info">
        <span class="selection-count">0</span> éléments sélectionnés
        <button class="ultra-btn ultra-btn-ghost ultra-btn-sm bulk-action-btn" style="display: none;">
          Actions groupées
          <i data-feather="chevron-down"></i>
        </button>
      </div>
      @endif
      
      @if($pagination && method_exists($data, 'links'))
      <div class="table-pagination">
        {{ $data->links() }}
      </div>
      @endif
    </div>
    @endif
  </div>
  
</div>

<!-- Enhanced Table Styles -->
<style>
  .table-header-left {
    flex: 1;
  }
  
  .table-header-right {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    flex-wrap: wrap;
  }
  
  .table-subtitle {
    color: var(--cerfaos-text-muted);
    font-size: 0.875rem;
    margin: var(--space-1) 0 0 0;
  }
  
  .table-filters {
    display: flex;
    gap: var(--space-2);
  }
  
  .table-search {
    min-width: 250px;
  }
  
  .table-container {
    overflow-x: auto;
    border-radius: var(--radius-lg);
  }
  
  .sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
  }
  
  .table-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-2);
  }
  
  .sort-arrows {
    display: flex;
    flex-direction: column;
    opacity: 0.3;
    transition: var(--transition);
  }
  
  .sortable:hover .sort-arrows {
    opacity: 0.7;
  }
  
  .sort-arrow {
    width: 12px;
    height: 12px;
    margin: -2px 0;
  }
  
  .sortable.sort-asc .sort-arrow.sort-asc,
  .sortable.sort-desc .sort-arrow.sort-desc {
    color: var(--cerfaos-gold);
    opacity: 1;
  }
  
  .table-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
  
  .table-checkbox input[type="checkbox"] {
    display: none;
  }
  
  .checkbox-mark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--cerfaos-border-light);
    border-radius: var(--radius-sm);
    position: relative;
    transition: var(--transition);
  }
  
  .table-checkbox input[type="checkbox"]:checked + .checkbox-mark {
    background: var(--gradient-nature);
    border-color: var(--cerfaos-sage);
  }
  
  .table-checkbox input[type="checkbox"]:checked + .checkbox-mark::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 12px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  
  .action-buttons {
    display: flex;
    gap: var(--space-1);
    justify-content: center;
  }
  
  .action-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: var(--glass-bg);
    color: var(--cerfaos-text-secondary);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
  }
  
  .action-btn:hover {
    background: var(--cerfaos-sage);
    color: white;
    transform: translateY(-1px);
  }
  
  .action-btn.delete-btn:hover {
    background: var(--cerfaos-error);
  }
  
  .table-image-placeholder {
    width: 40px;
    height: 40px;
    background: var(--cerfaos-surface);
    border: 1px solid var(--cerfaos-border);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cerfaos-text-muted);
  }
  
  .empty-state-content {
    padding: var(--space-8);
  }
  
  .empty-state-icon {
    margin-bottom: var(--space-4);
  }
  
  .table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4) var(--space-6);
    border-top: 1px solid var(--cerfaos-border);
    background: var(--cerfaos-dark-secondary);
  }
  
  .table-selection-info {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    color: var(--cerfaos-text-muted);
    font-size: 0.875rem;
  }
  
  .selection-count {
    font-weight: 600;
    color: var(--cerfaos-text-primary);
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .table-header-right {
      width: 100%;
      justify-content: space-between;
      margin-top: var(--space-4);
    }
    
    .table-filters {
      width: 100%;
      overflow-x: auto;
    }
    
    .action-buttons {
      flex-direction: column;
    }
    
    .table-footer {
      flex-direction: column;
      gap: var(--space-4);
      align-items: stretch;
    }
  }
</style>

<!-- Enhanced Table JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  initializeUltraTable('{{ $tableId }}');
});

function initializeUltraTable(tableId) {
  const table = document.getElementById(tableId);
  if (!table) return;
  
  const tableContainer = table.closest('[data-table-id]');
  
  // Initialize search
  const searchInput = tableContainer.querySelector('.table-search-input');
  if (searchInput) {
    searchInput.addEventListener('input', debounce(function(e) {
      filterTable(table, e.target.value);
    }, 300));
  }
  
  // Initialize sorting
  const sortableHeaders = table.querySelectorAll('.sortable');
  sortableHeaders.forEach(header => {
    header.addEventListener('click', function() {
      sortTable(table, this.dataset.column, this);
    });
  });
  
  // Initialize filters
  const filters = tableContainer.querySelectorAll('.table-filter');
  filters.forEach(filter => {
    filter.addEventListener('change', function() {
      applyFilters(table);
    });
  });
  
  // Initialize checkboxes
  const selectAllCheckbox = table.querySelector('.select-all-checkbox');
  const rowCheckboxes = table.querySelectorAll('.row-checkbox');
  
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
      rowCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
      updateSelectionCount(table);
    });
  }
  
  rowCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      updateSelectionCount(table);
      
      // Update select all checkbox
      if (selectAllCheckbox) {
        const checkedCount = table.querySelectorAll('.row-checkbox:checked').length;
        selectAllCheckbox.checked = checkedCount === rowCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
      }
    });
  });
}

function filterTable(table, searchTerm) {
  const rows = table.querySelectorAll('tbody .table-row');
  const term = searchTerm.toLowerCase();
  
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(term) ? '' : 'none';
  });
  
  updateEmptyState(table);
}

function sortTable(table, columnIndex, headerElement) {
  const tbody = table.querySelector('tbody');
  const rows = Array.from(tbody.querySelectorAll('.table-row'));
  
  // Remove existing sort classes
  table.querySelectorAll('.sortable').forEach(h => {
    h.classList.remove('sort-asc', 'sort-desc');
  });
  
  // Determine sort direction
  const isAscending = !headerElement.classList.contains('sort-asc');
  headerElement.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
  
  // Sort rows
  rows.sort((a, b) => {
    const aValue = a.cells[parseInt(columnIndex) + (table.querySelector('.select-all-checkbox') ? 1 : 0)].textContent.trim();
    const bValue = b.cells[parseInt(columnIndex) + (table.querySelector('.select-all-checkbox') ? 1 : 0)].textContent.trim();
    
    // Try to parse as numbers
    const aNum = parseFloat(aValue);
    const bNum = parseFloat(bValue);
    
    if (!isNaN(aNum) && !isNaN(bNum)) {
      return isAscending ? aNum - bNum : bNum - aNum;
    }
    
    // String comparison
    return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
  });
  
  // Re-append sorted rows
  rows.forEach(row => tbody.appendChild(row));
}

function applyFilters(table) {
  const tableContainer = table.closest('[data-table-id]');
  const filters = tableContainer.querySelectorAll('.table-filter');
  const rows = table.querySelectorAll('tbody .table-row');
  
  rows.forEach(row => {
    let showRow = true;
    
    filters.forEach(filter => {
      if (filter.value && showRow) {
        const filterColumn = filter.dataset.filter;
        const cellText = row.textContent.toLowerCase();
        if (!cellText.includes(filter.value.toLowerCase())) {
          showRow = false;
        }
      }
    });
    
    row.style.display = showRow ? '' : 'none';
  });
  
  updateEmptyState(table);
}

function updateSelectionCount(table) {
  const tableContainer = table.closest('[data-table-id]');
  const checkedBoxes = table.querySelectorAll('.row-checkbox:checked');
  const selectionCount = tableContainer.querySelector('.selection-count');
  const bulkActionBtn = tableContainer.querySelector('.bulk-action-btn');
  
  if (selectionCount) {
    selectionCount.textContent = checkedBoxes.length;
  }
  
  if (bulkActionBtn) {
    bulkActionBtn.style.display = checkedBoxes.length > 0 ? 'inline-flex' : 'none';
  }
}

function updateEmptyState(table) {
  const visibleRows = table.querySelectorAll('tbody .table-row[style=""], tbody .table-row:not([style])');
  const emptyState = table.querySelector('.empty-state');
  
  if (emptyState) {
    emptyState.style.display = visibleRows.length === 0 ? '' : 'none';
  }
}

function exportTable(tableId) {
  const table = document.getElementById(tableId);
  if (!table) return;
  
  // Simple CSV export
  const rows = [];
  const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
  rows.push(headers);
  
  table.querySelectorAll('tbody .table-row').forEach(row => {
    if (row.style.display !== 'none') {
      const cells = Array.from(row.cells).map(cell => cell.textContent.trim());
      rows.push(cells);
    }
  });
  
  const csvContent = rows.map(row => row.join(',')).join('\n');
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const link = document.createElement('a');
  const url = URL.createObjectURL(blob);
  
  link.setAttribute('href', url);
  link.setAttribute('download', `${tableId}_export_${new Date().getTime()}.csv`);
  link.style.visibility = 'hidden';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}
</script>