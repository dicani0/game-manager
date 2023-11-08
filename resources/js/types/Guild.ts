export interface Guild {
    id: number;
    name: string;
    recruiting: boolean;
    description: string;
    characters: Member[];
}

export interface Member {
    id: number;
    name: string;
    nickname: string;
    vocation: string;
    role: string;
}