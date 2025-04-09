import { toast as toastShadcn } from '@/components/ui/toast/use-toast';

export interface ToastProps {
  title?: string;
  description?: string;
  variant?: 'default' | 'destructive';
}

export const useToast = () => toastShadcn; 