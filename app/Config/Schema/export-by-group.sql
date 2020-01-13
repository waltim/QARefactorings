-- SELECT
-- ans.user_id, 
-- transf.id as transformation, transf.transformation_type_id,
-- replace(ans.choice,'OP','') as Question
-- FROM result_questions as resq 
-- inner join answers as ans on ans.result_question_id = resq.id
-- inner join users as user on ans.user_id = user.id
-- inner join results as res on resq.result_id = res.id
-- inner join transformations as transf on res.transformation_id = transf.id
-- WHERE resq.question_id = 2 and user.trophy = 42 and mod(ans.user_id,2) = 0
-- ORDER BY ans.user_id asc,transf.id asc, resq.question_id asc;

SELECT
replace(ans.choice,'OP','') as Question
FROM result_questions as resq 
inner join answers as ans on ans.result_question_id = resq.id
inner join users as user on ans.user_id = user.id
inner join results as res on resq.result_id = res.id
inner join transformations as transf on res.transformation_id = transf.id
WHERE resq.question_id = 6 and user.trophy = 42 and mod(ans.user_id,2) != 0
ORDER BY ans.user_id asc,transf.id asc, resq.question_id asc;