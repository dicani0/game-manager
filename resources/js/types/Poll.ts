import {Pagination} from "@/types/Shared";

export interface Poll {
    id: number,
    title: string,
    description: string | null,
    start_date: string | null,
    end_date: string | null,
    status: PollStatus,
    pollable_id: number | null,
    pollable_type: string | null,
    questions: PollQuestion[],
}

export interface PollQuestion {
    id?: number,
    poll_id?: number,
    question: string,
    type: string,
    answers: PollQuestionAnswer[],
    votes_count?: number,
}

export interface PollQuestionAnswer {
    id?: number,
    poll_question_id?: number,
    content: string,
    votes_count?: number,
    votes?: Vote[],
}

export interface PollQuestionAnswerWithVotes extends PollQuestionAnswer {
    votes: Vote[],
    votes_count: number,
}

export interface Vote {
    id: number,
    user_id: number,
}

export interface PollPagination extends Pagination {
    data: Poll[],
}

export enum PollStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    CLOSED = 'closed',
    STARTED = 'started',
}