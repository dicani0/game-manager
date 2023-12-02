import {Pagination} from "@/types/Shared";

export interface Poll {
    id: number,
    title: string,
    description: string | null,
    start_date: string | null,
    end_date: string | null,
    status: string,
    pollable_id: number | null,
    pollable_type: string | null,
}

export interface PollPagination extends Pagination {
    data: Poll[],
}