@php
// Define size classes
$sizeClasses = [
'sm' => 'px-3.5 py-2 text-xs',
'md' => 'px-5 py-2.5 text-sm',
'lg' => 'px-5 py-3 text-base',
];

// Define color classes
$colorClasses = [
'primary' => [
'bg' => 'bg-color-primary-500',
'border' => 'border-color-primary-500',
'text' => 'text-white',
'hover' => 'hover:bg-color-primary-400',
'outlined_bg' => 'bg-color-primary-100',
'outlined_text' => 'text-color-primary-500',
'outlined_hover' => 'hover:bg-color-primary-200',
],
'success' => [
'bg' => 'bg-color-success-500',
'border' => 'border-color-success-500',
'text' => 'text-white',
'hover' => 'hover:bg-color-success-400',
'outlined_bg' => 'bg-color-success-100',
'outlined_text' => 'text-color-success-500',
'outlined_hover' => 'hover:bg-color-success-200',
],
'warning' => [
'bg' => 'bg-color-warning-500',
'border' => 'border-color-warning-500',
'text' => 'text-white',
'hover' => 'hover:bg-color-warning-400',
'outlined_bg' => 'bg-color-warning-100',
'outlined_text' => 'text-color-warning-500',
'outlined_hover' => 'hover:bg-color-warning-200',
],
'info' => [
'bg' => 'bg-color-info-500',
'border' => 'border-color-info-500',
'text' => 'text-white',
'hover' => 'hover:bg-color-info-400',
'outlined_bg' => 'bg-color-info-100',
'outlined_text' => 'text-color-info-500',
'outlined_hover' => 'hover:bg-color-info-200',
],
'danger' => [
'bg' => 'bg-color-danger-500',
'border' => 'border-color-danger-500',
'text' => 'text-white',
'hover' => 'hover:bg-color-danger-400',
'outlined_bg' => 'bg-color-danger-100',
'outlined_text' => 'text-color-danger-500',
'outlined_hover' => 'hover:bg-color-danger-200',
],
// Add other color schemes as needed
];

// Determine if button is outlined or filled
$isOutlined = $outlined ? 'border ' . $colorClasses[$colors]['border'] . ' ' . $colorClasses[$colors]['outlined_bg'] . '
' . $colorClasses[$colors]['outlined_text'] . ' ' . $colorClasses[$colors]['outlined_hover'] :
$colorClasses[$colors]['bg'] . ' ' . $colorClasses[$colors]['text'] . ' ' . $colorClasses[$colors]['hover'];

// Combine classes
$classes = $sizeClasses[$size] . ' font-medium rounded-lg transition-colors ' . $isOutlined . ' ' . $customClass;
@endphp

<button type="{{ $type }}" class="{{ $classes }}">
    {{ $content }}
</button>