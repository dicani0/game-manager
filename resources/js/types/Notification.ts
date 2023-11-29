export interface Notification {
    id: string;
    type: string;
    notifiable_type: string;
    notifiable_id: string | number;
    data: unknown;
    read_at: Date | null;
    created_at: Date;
    updated_at: Date | null;
}

export interface NotificationsPagination {
    data: Notification[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
}