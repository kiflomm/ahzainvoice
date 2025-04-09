<template>
  <span
    :class="[
      'inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2',
      variantStyles[variant]
    ]"
  >
    <slot />
  </span>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  variant?: 'default' | 'secondary' | 'destructive' | 'outline' | 'success' | 'warning'
}>(), {
  variant: 'default'
});

const variantStyles = {
  default: 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80',
  secondary: 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
  destructive: 'border-transparent bg-red-100 text-red-800 hover:bg-red-200',
  outline: 'text-foreground border border-input hover:bg-accent hover:text-accent-foreground',
  success: 'border-transparent bg-green-100 text-green-800 hover:bg-green-200',
  warning: 'border-transparent bg-yellow-100 text-yellow-800 hover:bg-yellow-200',
};
</script>
