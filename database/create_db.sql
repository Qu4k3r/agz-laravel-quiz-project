create table subjects
(
    id         uuid         not null
        primary key,
    name       varchar(255) not null,
    created_at timestamp(0) not null,
    updated_at timestamp(0) not null
);

comment on column subjects.id is '(DC2Type:uuid)';

alter table subjects
    owner to root;

create unique index uniq_ab2599175e237e06
    on subjects (name);

create table questions
(
    id         uuid         not null
        primary key,
    subject_id uuid
        constraint fk_8adc54d523edc87
            references subjects,
    name       text         not null,
    created_at timestamp(0) not null,
    updated_at timestamp(0) not null
);

comment on column questions.id is '(DC2Type:uuid)';

comment on column questions.subject_id is '(DC2Type:uuid)';

alter table questions
    owner to root;

create index idx_8adc54d523edc87
    on questions (subject_id);

create table alternatives
(
    id          uuid         not null
        primary key,
    question_id uuid
        constraint fk_46682b541e27f6bf
            references questions,
    name        text         not null,
    is_correct  boolean      not null,
    created_at  timestamp(0) not null,
    updated_at  timestamp(0) not null
);

comment on column alternatives.id is '(DC2Type:uuid)';

comment on column alternatives.question_id is '(DC2Type:uuid)';

alter table alternatives
    owner to root;

create index idx_46682b541e27f6bf
    on alternatives (question_id);

create table students
(
    id         uuid         not null
        primary key,
    name       varchar(255) not null,
    lastname   varchar(255) not null,
    created_at timestamp(0) not null,
    updated_at timestamp(0) not null
);

comment on column students.id is '(DC2Type:uuid)';

alter table students
    owner to root;

create table quizzes
(
    id              uuid         not null
        primary key,
    student_id      uuid
        constraint fk_94dc9fb5cb944f1a
            references students,
    subject         varchar(255) not null,
    total_questions smallint     not null,
    score           double precision,
    status          varchar(255) not null,
    created_at      timestamp(0) not null,
    updated_at      timestamp(0) not null
);

comment on column quizzes.id is '(DC2Type:uuid)';

comment on column quizzes.student_id is '(DC2Type:uuid)';

alter table quizzes
    owner to root;

create index idx_94dc9fb5cb944f1a
    on quizzes (student_id);

create table snapshots
(
    id                  uuid         not null
        primary key,
    quiz_id             uuid
        constraint fk_4d91463d853cd175
            references quizzes,
    student_id          uuid
        constraint fk_4d91463dcb944f1a
            references students,
    subject_name        varchar(255) not null,
    question_name       text         not null,
    alternative_name    text         not null,
    is_correct          boolean      not null,
    student_alternative text,
    right_answer        boolean,
    created_at          timestamp(0) not null,
    updated_at          timestamp(0) not null
);

comment on column snapshots.id is '(DC2Type:uuid)';

comment on column snapshots.quiz_id is '(DC2Type:uuid)';

comment on column snapshots.student_id is '(DC2Type:uuid)';

alter table snapshots
    owner to root;

create index idx_4d91463d853cd175
    on snapshots (quiz_id);

create index idx_4d91463dcb944f1a
    on snapshots (student_id);


