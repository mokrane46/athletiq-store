@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; margin-bottom: 50px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
        <a href="{{ route('admin.products.index') }}" style="color: var(--text-muted); font-size: 1.2rem; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-muted)'">
            <i class='bx bx-arrow-back'></i>
        </a>
        <span class="premium-eyebrow" style="margin-bottom: 0;">Inventory Management</span>
    </div>
    <h1 class="premium-title">Deploy Product</h1>
</div>
<div class="premium-card" style="max-width: 900px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div class="premium-form-group" style="grid-column: span 2;">
                <label class="premium-label" for="Product_name">Product Title</label>
                <input type="text" name="Product_name" id="Product_name" class="premium-input" placeholder="e.g. Performance Tech Tee" value="{{ old('Product_name') }}" required>
                @error('Product_name')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
            </div>
            <div class="premium-form-group">
                <label class="premium-label" for="Price">Unit Price ($)</label>
                <input type="number" step="0.01" name="Price" id="Price" class="premium-input" placeholder="0.00" value="{{ old('Price') }}" required>
                @error('Price')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
            </div>
            <div class="premium-form-group">
                <label class="premium-label" for="Quantity">Initial Stock</label>
                <input type="number" name="Quantity" id="Quantity" class="premium-input" placeholder="0" value="{{ old('Quantity') }}" required>
                @error('Quantity')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
            </div>
            <div class="premium-form-group" style="grid-column: span 2;">
                <label class="premium-label" for="SubCategory_ID">Category Assignment</label>
                <select name="SubCategory_ID" id="SubCategory_ID" class="premium-input" required>
                    <option value="">Select a subcategory</option>
                    @foreach($subcategories as $sub)
                        @php $catName = strtolower($sub->category->Category_name ?? ''); @endphp
                        <option value="{{ $sub->SubCategory_ID }}" 
                                data-category="{{ $catName }}"
                                {{ old('SubCategory_ID') == $sub->SubCategory_ID ? 'selected' : '' }}>
                            {{ $sub->category->Category_name ?? 'Uncategorized' }} > {{ $sub->SubCategory_name }}
                        </option>
                    @endforeach
                </select>
                @error('SubCategory_ID')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
            </div>
        </div>
        <div id="dynamic-fields-container" style="background: var(--bg-secondary); border-radius: 15px; padding: 25px; margin-bottom: 30px; display: none; border: 1px dashed rgba(0,0,0,0.1);">
            <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 20px;">Technical Specifications</div>
            <div id="dynamic-fields" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;"></div>
        </div>
        <div class="premium-form-group" style="margin-bottom: 40px;">
            <label class="premium-label" for="Product_image">Product Media</label>
            <div style="border: 2px dashed rgba(50, 255, 126, 0.2); border-radius: 15px; padding: 40px; text-align: center; position: relative; transition: all 0.3s ease; background: rgba(50, 255, 126, 0.02);" onmouseover="this.style.borderColor='var(--accent)'; this.style.background='rgba(50, 255, 126, 0.05)'" onmouseout="this.style.borderColor='rgba(50, 255, 126, 0.2)'; this.style.background='rgba(50, 255, 126, 0.02)'">
                <i class='bx bx-cloud-upload' style="font-size: 3rem; color: var(--accent); margin-bottom: 10px; display: block;"></i>
                <p style="font-size: 0.9rem; color: var(--text-secondary); font-weight: 600;">Drag & Drop or Click to Upload</p>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 5px;">SVG, PNG, JPG or GIF (max. 2MB)</p>
                <input type="file" name="Product_image" id="Product_image" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;" required>
                <div id="file-name-display" style="font-size: 0.85rem; font-weight: 700; color: var(--accent); margin-top: 15px; display: none;"></div>
            </div>
            @error('Product_image')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
        </div>
        <div style="display: flex; gap: 20px;">
            <button type="submit" class="premium-btn" style="flex: 2;">Confirm Deployment</button>
            <a href="{{ route('admin.products.index') }}" class="premium-btn premium-btn-outline" style="flex: 1; text-decoration: none;">Discard</a>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const subcategorySelect = document.getElementById('SubCategory_ID');
    const dynamicFieldsContainer = document.getElementById('dynamic-fields-container');
    const dynamicFields = document.getElementById('dynamic-fields');
    const imageInput = document.getElementById('Product_image');
    const fileNameDisplay = document.getElementById('file-name-display');
    // Handle Image Preview/Name
    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            fileNameDisplay.style.display = 'block';
            fileNameDisplay.textContent = `Selected: ${e.target.files[0].name}`;
        }
    });
    const updateFields = () => {
        const selectedOption = subcategorySelect.options[subcategorySelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) {
            dynamicFieldsContainer.style.display = 'none';
            return;
        }
        const category = selectedOption.dataset.category;
        dynamicFields.innerHTML = '';
        let hasFields = false;
        if (category === 'clothes') {
            hasFields = true;
            const fields = [
                { label: 'Primary Color', name: 'Color', type: 'select', options: ['Red','Blue','Green','Black','White','Navy','Grey'] },
                { label: 'Size Variant', name: 'Size', type: 'select', options: ['S','M','L','XL','XXL'] },
                { label: 'Brand/Manufacturer', name: 'Brand', type: 'text' }
            ];
            fields.forEach(f => {
                const div = document.createElement('div');
                div.className = 'premium-form-group';
                if (f.type === 'select') {
                    let optionsHTML = `<option value="">Select ${f.label}</option>` +
                                      f.options.map(o => `<option value="${o}">${o}</option>`).join('');
                    div.innerHTML = `<label class="premium-label">${f.label}</label>
                                     <select name="specifications[${f.name}]" class="premium-input" required>${optionsHTML}</select>`;
                } else {
                    div.innerHTML = `<label class="premium-label">${f.label}</label>
                                     <input type="text" name="specifications[${f.name}]" class="premium-input" placeholder="Enter ${f.label}" required>`;
                }
                dynamicFields.appendChild(div);
            });
        } else if (category === 'weights' || category === 'dumbbells') {
            hasFields = true;
            const div = document.createElement('div');
            div.className = 'premium-form-group';
            div.style.gridColumn = 'span 2';
            div.innerHTML = `<label class="premium-label">Weight Specification (kg)</label>
                             <input type="number" step="0.1" name="specifications[Weight]" class="premium-input" placeholder="e.g. 10.5" required>`;
            dynamicFields.appendChild(div);
        }
        dynamicFieldsContainer.style.display = hasFields ? 'block' : 'none';
    };
    subcategorySelect.addEventListener('change', updateFields);
    if (subcategorySelect.value) updateFields(); // Handle back navigation or validation errors
});
</script>
@endsection
