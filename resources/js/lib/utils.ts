import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function objectToUrl(baseUrl: string, params: Record<string, any> ): string {
    const urlParams =  new URLSearchParams('');

    Object.keys(params).forEach((key: string) => {
        if(params[key]) {
            urlParams.append(key, params[key]);
        }
    })

    return baseUrl + '?' + urlParams.toString();
}