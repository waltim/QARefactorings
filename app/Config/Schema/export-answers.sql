SELECT user.id as participante, user.sex as sexo, user.formation as formação,
 user.profession as profissão, user.functional_program as programação_funcional, user.lambda_exp as experiência_com_lambda,
 usl.experience as experiência_com_java,
 transf.id as transformação, transf.transformation_type_id as tipo_transformação,
 resq.question_id as questão,
replace(resp.choice,'OP','') as opção_escolhida, resp.justify as justificativa
FROM qar_backup.users as user inner join answers as resp on user.id = resp.user_id 
inner join user_languages as usl on usl.user_id = user.id
inner join result_questions as resq on resp.result_question_id = resq.id
inner join results as rest on resq.result_id = rest.id
inner join transformations as transf on rest.transformation_id = transf.id
where user.trophy = 42 and resq.question_id <= 6;