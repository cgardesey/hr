<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {

        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'logout', 'Error', 'employeeimport', 'checkmail',
                    'Users', 'Fetchbatch', 'Userslist', 'Resetpassword', 'Fetchbatchforgua',
                    'Superadmin', 'Savetodo', 'Deletetodo', 'Updatetodo', 'Drawfeegraph', 'CreateExcel',
                    'Dataexport', 'Feeimport', 'Fetchbatch_online', 'createonline', 'captcha', 'Onlineenquiry',
                    'Libraryimport', 'Saveattendancedetails', 'Resetdata', 'Datareset', 'Feeallocationimport'),
                'users' => array('@'),
            ),
            array('deny', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('*'),
            ),
        );
    }

    /*
     * This function is used for import fees allocation details
     */

    public function actionFeeallocationimport() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $uploadedFile = CUploadedFile::getInstance($model, 'filea');
            if ($uploadedFile == "") {
                Yii::app()->user->setFlash('error', 'Please select a file.');
            } else {
                $allowed = array('xlsx');
                $filename = CUploadedFile::getInstance($model, 'filea');
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    throw new CHttpException(404, 'File extension error. The allowed extension is xlsx.');
                    exit(0);
                } else {
                    $ext = end((explode(".", $uploadedFile)));
                    $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                    $date = new DateTime();
                    $date->setTimezone($timezone);
                    $date = $date->format('dmYhis');
                    $fileName = "{$date}.{$ext}";
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                    //reading portion : here each column is read row and column wise; please check the sample
                    //import file to get the column format. The heading row can be kept. The heading is ignored
                    //while reading the excel or csv file.

                    $sheet_array = Yii::app()->yexcel->readActiveSheet(Yii::app()->basePath . '/../banner/' . $fileName);
                    $count = 0;
                    $x = 2;
                    foreach ($sheet_array as $row) {
                        $count = $count + 1;
                    }
                    for ($x = 2; $x <= $count; $x++) {
                        try {

                            if (
                                    ( $sheet_array[$x]['A'] == "" || $sheet_array[$x]['A'] == " ") &&
                                    ( $sheet_array[$x]['B'] == "" || $sheet_array[$x]['B'] == " ") &&
                                    ( $sheet_array[$x]['C'] == "" || $sheet_array[$x]['C'] == " ") &&
                                    ( $sheet_array[$x]['D'] == "" || $sheet_array[$x]['D'] == " ") &&
                                    ( $sheet_array[$x]['E'] == "" || $sheet_array[$x]['E'] == " ") &&
                                    ( $sheet_array[$x]['F'] == "" || $sheet_array[$x]['F'] == " ") &&
                                    ( $sheet_array[$x]['G'] == "" || $sheet_array[$x]['G'] == " ")
                            ) {
                                break;
                                //$this->redirect(array('/core/student/admin'), array('message' => 'Successfuly Updated!'));
                            }
                            $feesallocation = new Feesallocation();
                            $student_admissionnum = Student::model()->findByAttributes(array('student_admissionno' => $sheet_array[$x]['A']));
                            if ($sheet_array[$x]['F'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field date validation error');
                                exit(0);
                            } else {
                                $date1 = date_create($sheet_array[$x]['F']);
                                $date = date_format($date1, 'Y-m-d');
                                $feesallocation->date = $date;
                            }
                            if ($sheet_array[$x]['D'] != "") {
                                $course = Course::model()->findByAttributes(array('course_name' => $sheet_array[$x]['D']));
                                $batch = Batch::model()->findByAttributes(array('batch_name' => $sheet_array[$x]['E'], 'courseid' => $course->courseid));
                            }
                            $feefor = $sheet_array[$x]['C'];
                            if ($feefor == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field fees for validation error');
                                exit(0);
                            }
                            if ($feefor == "Student in a batch") {
                                $category = Feescategory::model()->findByAttributes(array('feescategory_name' => $sheet_array[$x]['G']));
                                if ($category == "") {
                                    throw new CHttpException(404, 'Row number :' . $x . 'The field category validation error');
                                    exit(0);
                                } else {
                                    $subcategory = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $sheet_array[$x]['B'], 'feescategoryid' => $category->feescategoryid));
                                    if ($subcategory == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field subcategory validation error');
                                        exit(0);
                                    } else {
                                        $feesallocation->courseid = $student_admissionnum->courseid;
                                        $feesallocation->batchid = $student_admissionnum->batchid;
                                        $feesallocation->studentid = $student_admissionnum->studentid;
                                        $feesallocation->feessubcategoryid = $subcategory->feessubcategoryid;
                                        $feesallocation->companyid = Yii::app()->user->companyid;
                                        $feesallocation->feesfor = 3;
                                        $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $student_admissionnum->studentid, 'companyid' => Yii::app()->user->companyid));
                                        if (isset($feestruc)) {
                                            $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $subcategory->feessubcategoryid . ",";
                                            $feestruc->save(false);
                                        } else {
                                            $modelf = new Studentfeesstructure;
                                            $modelf->studentid = $student_admissionnum->studentid;
                                            $modelf->feessubcategoryid = $subcategory->feessubcategoryid . ",";
                                            $modelf->companyid = Yii::app()->user->companyid;
                                            $modelf->save(false);
                                        }
                                    }
                                }
                            }
                            if ($feefor == "Selected batch") {
                                $category = Feescategory::model()->findByAttributes(array('feescategory_name' => $sheet_array[$x]['G']));
                                if ($category == "") {
                                    throw new CHttpException(404, 'Row number :' . $x . 'The field category validation error');
                                    exit(0);
                                } else {
                                    $subcategory = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $sheet_array[$x]['B'], 'feescategoryid' => $category->feescategoryid));
                                    if ($subcategory == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field subcategory validation error');
                                        exit(0);
                                    } else {
                                        $feesallocation->courseid = $course->courseid;
                                        $feesallocation->batchid = $batch->batchid;
                                        $feesallocation->studentid = NULL;
                                        $feesallocation->feessubcategoryid = $subcategory->feessubcategoryid;
                                        $feesallocation->companyid = Yii::app()->user->companyid;
                                        $feesallocation->feesfor = 2;
                                        $students = Student::model()->findAllByAttributes(array('batchid' => $batch->batchid));
                                        foreach ($students as $student) {
                                            if ($student->courseid != "" && $student->batchid != "") {
                                                $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $student->studentid, 'companyid' => Yii::app()->user->companyid));
                                                if (isset($feestruc)) {
                                                    $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $subcategory->feessubcategoryid . ",";
                                                    $feestruc->save(false);
                                                } else {
                                                    $modelf = new Studentfeesstructure;
                                                    $modelf->studentid = $student->studentid;
                                                    $modelf->feessubcategoryid = $subcategory->feessubcategoryid . ",";
                                                    $modelf->companyid = Yii::app()->user->companyid;
                                                    $modelf->save(false);
                                                }
                                            }
                                        }
                                    }
                                }
                            } if ($feefor == "All batches") {
                                $category = Feescategory::model()->findByAttributes(array('feescategory_name' => $sheet_array[$x]['G']));
                                if ($category == "") {
                                    throw new CHttpException(404, 'Row number :' . $x . 'The field category validation error');
                                    exit(0);
                                } else {
                                    $subcategory = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $sheet_array[$x]['B'], 'feescategoryid' => $category->feescategoryid));
                                    if ($subcategory == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field subcategory validation error');
                                        exit(0);
                                    } else {
                                        $feesallocation->courseid = NULL;
                                        $feesallocation->batchid = NULL;
                                        $feesallocation->studentid = NULL;
                                        $feesallocation->feessubcategoryid = $subcategory->feessubcategoryid;
                                        $feesallocation->companyid = Yii::app()->user->companyid;
                                        $feesallocation->feesfor = 1;
                                        $students = Student::model()->findAll();
                                        foreach ($students as $student) {
                                            if ($student->courseid != "" && $student->batchid != "") {
                                                $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $student->studentid, 'companyid' => Yii::app()->user->companyid));
                                                if (isset($feestruc)) {
                                                    $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $subcategory->feessubcategoryid . ",";
                                                    $feestruc->save(false);
                                                } else {
                                                    $modelf = new Studentfeesstructure;
                                                    $modelf->studentid = $student->studentid;
                                                    $modelf->feessubcategoryid = $subcategory->feessubcategoryid . ",";
                                                    $modelf->companyid = Yii::app()->user->companyid;
                                                    $modelf->save(false);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
//                            else {
//                                $this->render('feeallcationform', array('model' => $model, 'message' => 'Plese enter the fees categories and sub categories in proper!'));
//                            }

                            $feesallocation->save(false);
                        } catch (CDbException $e) {
                            throw new CHttpException(404, 'Something went wrong while uploading your excel file.');
                        }
                    }
                    if ($x == 2) {
                        $this->render('feeallocationform', array('model' => $model, 'message' => 'The file you uploaded is empty.!'));
                    } else {
                        $this->redirect(array('/core/feesallocation/create'));
                    }
                }
            }
        }
        $this->render('feeallocationform', array('model' => $model, 'message' => ''));
    }

    /*
     * A Function
     * Used for reset all datas with active academicyear
     */

    public function actionDatareset() {

        $dataof = $_POST['dataof'];
        $academic = Academic::model()->findByAttributes(array('status' => 1));  //! $academic stores active academic year details
        if ($dataof === '1') {  //! class teacher and subject allocation 
            $classteacher = Classteacherallocation::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($classteacher)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $teacher = Classteacherallocation::model()->find(array(
                    "order" => "classteacherallocationid DESC",
                    "limit" => 1,
                ));
                $classteachers = Classteacherallocation::model()->findAll('academicid=' . $teacher->academicid);
                foreach ($classteachers as $classteacher) {
                    $model_class = new Classteacherallocation;
                    $model_class->employeeid = $classteacher->employeeid;
                    $model_class->courseid = $classteacher->courseid;
                    $model_class->batchid = $classteacher->batchid;
                    $model_class->companyid = Yii::app()->user->companyid;
                    $model_class->academicid = $academic->academicid;

                    $model_class->save(false);
                }
            }

            $subjectallocation = Subjectallocation::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($subjectallocation)) {
                
            } else {
                $subjectalloc = Subjectallocation::model()->find(array(
                    "order" => "subjectallocationid DESC",
                    "limit" => 1,
                ));
                $subjectallocations = Subjectallocation::model()->findAll('academicid=' . $teacher->academicid);
                foreach ($subjectallocations as $subjectallocation) {
                    $model_subject = new Subjectallocation;
                    $model_subject->courseid = $subjectallocation->courseid;
                    $model_subject->batchid = $subjectallocation->batchid;
                    $model_subject->subjectid = $subjectallocation->subjectid;
                    $model_subject->employeeid = $subjectallocation->employeeid;
                    $model_subject->companyid = $subjectallocation->companyid;
                    $model_subject->departmentid = $subjectallocation->departmentid;
                    $model_subject->academicid = $academic->academicid;

                    $model_subject->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }

        if ($dataof === '2') { //! GPA exam details
            //! GPA Term
            $terms = Term::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($terms)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $trm = Subjectallocation::model()->find(array(
                    "order" => "subjectallocationid DESC",
                    "limit" => 1,
                ));
                $terms = Term::model()->findAll('academicid=' . $trm->academicid);
                foreach ($terms as $term) {
                    $model_term = new Term;
                    $model_term->term_name = $term->term_name;
                    $model_term->term_startdate = $term->term_startdate;
                    $model_term->term_enddate = $term->term_enddate;
                    $model_term->companyid = $term->companyid;
                    $model_term->academicid = $academic->academicid;

                    $model_term->save(false);
                }
            }
            //! GPA exam creation
            $exam = Exam::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($exam)) {
                
            } else {
                $exm = Exam::model()->find(array(
                    "order" => "examid DESC",
                    "limit" => 1,
                ));
                $exams = Exam::model()->findAll('academicid=' . $exm->academicid);
                foreach ($exams as $exam) {
                    $model_exam = new Exam;
                    $model_exam->exam_name = $exam->exam_name;
                    $termo = Term::model()->findByPk($exam->termid);
                    $termn = Term::model()->findByAttributes(array('term_name' => $termo->term_name, 'academicid' => $academic->academicid));
                    $model_exam->termid = $termn->termid;
                    $model_exam->companyid = $exam->companyid;
                    $model_exam->academicid = $academic->academicid;
                }
            }
            //! Gpa skill creation
            $skill = Gpaskills::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($skill)) {
                
            } else {
                $skil = Gpaskills::model()->find(array(
                    "order" => "gpaskillsid DESC",
                    "limit" => 1,
                ));
                $skills = Gpaskills::model()->findAll('academicid=' . $skil->academicid);
                foreach ($skills as $gpaskill) {
                    $model_skill = new Gpaskills;
                    $model_skill->gpaskills_name = $gpaskill->gpaskills_name;
                    $model_skill->academicid = $academic->academicid;
                    $model_skill->save(false);
                }
            }
            //! Gpa sub skill creation
            $subskill = Gpasubskills::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($subskill)) {
                
            } else {
                $subskil = Gpasubskills::model()->find(array(
                    "order" => "gpasubskillsid DESC",
                    "limit" => 1,
                ));
                $subskills = Gpasubskills::model()->findAll('academicid=' . $subskil->academicid);
                foreach ($subskills as $gpasubskill) {
                    $model_subskill = new Gpasubskills;
                    $skillo = Gpaskills::model()->findByPk($gpasubskill->gpaskillsid);
                    $skilln = Gpaskills::model()->findByAttributes(array('gpaskills_name' => $skillo->gpaskills_name, 'academicid' => $academic->academicid));

                    $model_subskill->gpaskillsid = $skilln->gpaskillsid;
                    $model_subskill->gpasubskills_name = $gpasubskill->gpasubskills_name;
                    $model_subskill->weightage = $gpasubskill->weightage;
                    $model_subskill->academicid = $academic->academicid;
                    $model_subskill->save(false);
                }
            }
            //! Grade scale creation
            $gradescale = Gradescale::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($gradescale)) {
                
            } else {
                $grade = Gradescale::model()->find(array(
                    "order" => "gradescaleid DESC",
                    "limit" => 1,
                ));
                $gradescales = Gradescale::model()->findAll('academicid=' . $grade->academicid);
                foreach ($gradescales as $grades) {
                    $model_grade = new Gradescale;
                    $model_grade->gradescale_grade = $grades->gradescale_grade;
                    $model_grade->gradescale_value = $grades->gradescale_value;
                    $model_grade->gradescale_lowmark = $grades->gradescale_lowmark;
                    $model_grade->gradescale_uppermark = $grades->gradescale_uppermark;
                    $model_grade->gradescale_status = $grades->gradescale_status;
                    $model_grade->academicid = $academic->academicid;
                    $model_grade->save(false);
                }
            }
            //! subject credit point creation
            $subjectcreditpoint = Subjectcreditpoint::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($subjectcreditpoint)) {
                
            } else {
                $subcrpnt = Subjectcreditpoint::model()->find(array(
                    "order" => "subjectcreditpointid DESC",
                    "limit" => 1,
                ));
                $creditpoints = Subjectcreditpoint::model()->findAll('academicid=' . $subcrpnt->academicid);
                foreach ($creditpoints as $creditpoint) {
                    $model_credit = new Subjectcreditpoint;
                    $model_credit->subjectid = $creditpoint->subjectid;
                    $model_credit->subjectcreditpoint_value = $creditpoint->subjectcreditpoint_value;
                    $model_credit->academicid = $academic->academicid;
                    $model_credit->save(false);
                }
            }
            //! total mark percentage creation
            $totmark = Totalmark::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($totmark)) {
                
            } else {
                $mark = Totalmark::model()->find(array(
                    "order" => "totalmarkid DESC",
                    "limit" => 1,
                ));
                $totalmarks = Subjectcreditpoint::model()->findAll('academicid=' . $mark->academicid);
                foreach ($totalmarks as $totalmark) {
                    $model_mark = new Totalmark;
                    $model_mark->companyid = Yii::app()->user->companyid;
                    $model_mark->totalmark_assessmentexam = $totalmark->totalmark_assessmentexam;
                    $model_mark->totalmark_writtenexam = $totalmark->totalmark_writtenexam;
                    $model_mark->academicid = $academic->academicid;
                    $model_mark->save(false);
                }
            }
            //! Assessment creation
            $assmnt = Assessment::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($assmnt)) {
                
            } else {
                $asmnt = Assessment::model()->find(array(
                    "order" => "assessmentid DESC",
                    "limit" => 1,
                ));
                $assessments = Assessment::model()->findAll('academicid=' . $asmnt->academicid);
                foreach ($assessments as $assessment) {
                    $model_assessment = new Assessment;
                    $model_assessment->assessment_name = $assessment->assessment_name;
                    $model_assessment->assessment_maxmark = $assessment->assessment_maxmark;
                    $model_assessment->assessment_common = $assessment->assessment_common;
                    $model_assessment->batchid = $assessment->batchid;
                    $model_assessment->companyid = Yii::app()->user->companyid;
                    $model_assessment->gradescaleid = $assessment->gradescaleid;
                    $model_assessment->courseid = $assessment->courseid;
                    $model_assessment->academicid = $academic->academicid;
                    $model_assessment->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        if ($dataof === '3') { //! CCE exam details
            //! cce category creation
            $ccecat = Ccecategory::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccecat)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $cat = Ccecategory::model()->find(array(
                    "order" => "ccecategoryid DESC",
                    "limit" => 1,
                ));
                $categories = Ccecategory::model()->findAll('academicid=' . $cat->academicid);
                foreach ($categories as $category) {
                    $model_cate = new Ccecategory;
                    $model_cate->ccecategoryname = $category->ccecategoryname;
                    $model_cate->academicid = $academic->academicid;
                    $model_cate->save(false);
                }
            }
            //! cce term creation
            $ccetrm = Cceterm::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccetrm)) {
                
            } else {
                $trm = Cceterm::model()->find(array(
                    "order" => "ccetermid DESC",
                    "limit" => 1,
                ));
                $terms = Cceterm::model()->findAll('academicid=' . $trm->academicid);
                foreach ($terms as $term) {
                    $model_term = new Cceterm;
                    $model_term->ccetermname = $term->ccetermname;
                    $model_term->startdate = $term->startdate;
                    $model_term->enddate = $term->enddate;
                    $model_term->academicid = $academic->academicid;
                    $model_term->save(false);
                }
            }
            //! Cce assesment creation
            $cceasmnt = Cceassessment::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceasmnt)) {
                
            } else {
                $assmnt = Cceassessment::model()->find(array(
                    "order" => "cceassessmentid DESC",
                    "limit" => 1,
                ));
                $cceassessments = Cceassessment::model()->findAll('academicid=' . $assmnt->academicid);
                foreach ($cceassessments as $cceassessment) {
                    $model_cceassessment = new Cceassessment;
                    $ccetermold = Cceterm::model()->findByPk($cceassessment->ccetermid);
                    $ccetermnew = Cceterm::model()->findByAttributes(array('ccetermname' => $ccetermold->ccetermname, 'academicid' => $academic->academicid));
                    $model_cceassessment->ccetermid = $ccetermnew->ccetermid;
                    $model_cceassessment->cceassessmenttype = $cceassessment->cceassessmenttype;
                    $model_cceassessment->cceassessmentname = $cceassessment->cceassessmentname;
                    $model_cceassessment->cceassessmentweightage = $cceassessment->cceassessmentweightage;
                    $model_cceassessment->academicid = $academic->academicid;
                    $model_cceassessment->save(false);
                }
            }
            //! Cce subject sub creation
            $ccesubjsub = Ccesubjectsub::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccesubjsub)) {
                
            } else {
                $subjsub = Ccesubjectsub::model()->find(array(
                    "order" => "ccesubjectsubid DESC",
                    "limit" => 1,
                ));
                $ccesubjectsubs = Ccesubjectsub::model()->findAll('academicid=' . $subjsub->academicid);
                foreach ($ccesubjectsubs as $ccesubjectsub) {
                    $model_ccesubjectsub = new Ccesubjectsub;
                    $model_ccesubjectsub->ccesubjectsubname = $ccesubjectsub->ccesubjectsubname;
                    $model_ccesubjectsub->subjectid = $ccesubjectsub->subjectid;
                    $model_ccesubjectsub->batchid = $ccesubjectsub->batchid;
                    $model_ccesubjectsub->courseid = $ccesubjectsub->courseid;
                    $model_ccesubjectsub->academicid = $academic->academicid;
                    $model_ccesubjectsub->save(false);
                }
            }
            //! cce skills creation
            $cceskl = Cceskills::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceskl)) {
                
            } else {
                $cceskil = Cceskills::model()->find(array(
                    "order" => "cceskillsid DESC",
                    "limit" => 1,
                ));
                $cceskills = Cceskills::model()->findAll('academicid=' . $cceskil->academicid);
                foreach ($cceskills as $cceskill) {
                    $model_cceskill = new Cceskills;
                    $ccecatold = Ccecategory::model()->findByPk($cceskill->ccecategoryid);
                    $ccecatnew = Ccecategory::model()->findByAttributes(array('ccecategoryname' => $ccecatold->ccecategoryname, 'academicid' => $academic->academicid));
                    $model_cceskill->ccecategoryid = $ccecatnew->ccecategoryid;
                    $model_cceskill->cceskillsname = $ccecatnew->cceskillsname;
                    $model_cceskill->cceskillsparentid = $ccecatnew->cceskillsparentid;
                    $model_cceskill->academicid = $academic->academicid;
                    $model_cceskill->save(false);
                }
            }
            //! cce indicators creation
            $cceind = Cceindicators::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceind)) {
                
            } else {
                $cceindi = Cceindicators::model()->find(array(
                    "order" => "cceindicatorid DESC",
                    "limit" => 1,
                ));
                $cceindicators = Cceindicators::model()->findAll('academicid=' . $cceindi->academicid);
                foreach ($cceindicators as $cceindicator) {
                    $model_cceindicator = new Cceindicators;
                    $cceskillold = Cceskills::model()->findByPk($cceindicator->cceskillid);
                    $cceskillnew = Cceskills::model()->findByAttributes(array('cceskillsname' => $cceskillold->cceskillsname, 'academicid' => $academic->academicid));
                    $model_cceindicator->cceskillid = $cceskillnew->cceskillsid;
                    $model_cceindicator->cceindicatordetails = $cceindicator->cceindicatordetails;
                    $model_cceindicator->academicid = $academic->academicid;
                    $model_cceindicator->save(false);
                }
            }
            //! cce grade set creation
            $ccegr = Ccegradeset::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccegr)) {
                
            } else {
                $ccegra = Ccegradeset::model()->find(array(
                    "order" => "ccegradesetid DESC",
                    "limit" => 1,
                ));
                $ccegradesets = Ccegradeset::model()->findAll('academicid=' . $ccegra->academicid);
                foreach ($ccegradesets as $ccegradeset) {
                    $model_ccegradeset = new Ccegradeset;
                    $model_ccegradeset->ccegradesetname = $ccegradeset->ccegradesetname;
                    $model_ccegradeset->academicid = $academic->academicid;
                    $model_ccegradeset->save(false);
                }
            }
            //! cce grades creation
            $ccegra = Ccegrades::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccegra)) {
                
            } else {
                $ccegrad = Ccegrades::model()->find(array(
                    "order" => "ccegradesid DESC",
                    "limit" => 1,
                ));
                $ccegrades = Ccegrades::model()->findAll('academicid=' . $ccegrad->academicid);
                foreach ($ccegrades as $ccegrade) {
                    $model_ccegrade = new Ccegrades;
                    $ccegradesetold = Ccegradeset::model()->findByPk($ccegrade->ccegradesetid);
                    $ccegradesetnew = Ccegradeset::model()->findByAttributes(array('ccegradesetname' => $ccegradesetold->ccegradesetname, 'academicid' => $academic->academicid));
                    $model_ccegrade->ccegradesetid = $ccegradesetnew->ccegradesetid;
                    $model_ccegrade->ccegradename = $ccegrade->ccegradename;
                    $model_ccegrade->ccegradelowerbound = $ccegrade->ccegradelowerbound;
                    $model_ccegrade->ccegradeupperbound = $ccegrade->ccegradeupperbound;
                    $model_ccegrade->ccegradepoint = $ccegrade->ccegradepoint;
                    $model_ccegrade->academicid = $academic->academicid;
                    $model_ccegrade->save(false);
                }
            }
            //! cce grade skill mapping creation
            $ccegrsk = Ccegradeskillmap::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccegrsk)) {
                
            } else {
                $ccegrask = Ccegradeskillmap::model()->find(array(
                    "order" => "ccegradeskillmapid DESC",
                    "limit" => 1,
                ));
                $ccegradeskillmaps = Ccegradeskillmap::model()->findAll('academicid=' . $ccegrask->academicid);
                foreach ($ccegradeskillmaps as $ccegradeskillmap) {
                    $model_gradeskillmap = new Ccegradeskillmap;
                    $ccegradesetold = Ccegradeset::model()->findByPk($ccegradeskillmap->ccegradesetid);
                    $ccegradesetnew = Ccegradeset::model()->findByAttributes(array('ccegradesetname' => $ccegradesetold->ccegradesetname, 'academicid' => $academic->academicid));
                    $model_gradeskillmap->ccegradesetid = $ccegradesetnew->ccegradesetid;
                    $cceskillold = Cceskills::model()->findByPk($ccegradeskillmap->cceskillid);
                    $cceskillnew = Cceskills::model()->findByAttributes(array('cceskillsname' => $cceskillold->cceskillsname, 'academicid' => $academic->academicid));
                    $model_gradeskillmap->cceskillid = $cceskillnew->cceskillsid;
                    $model_gradeskillmap->academicid = $academic->academicid;
                    $model_gradeskillmap->save(false);
                }
            }
            //! cce indicators grade creation
            $cceindgr = Cceindicatorsgrade::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceindgr)) {
                
            } else {
                $cceindigra = Cceindicatorsgrade::model()->find(array(
                    "order" => "cceindicatorsgradeid DESC",
                    "limit" => 1,
                ));
                $cceindigrades = Cceindicatorsgrade::model()->findAll('academicid=' . $cceindigra->academicid);
                foreach ($cceindigrades as $cceindigrade) {
                    $model_indigrade = new Cceindicatorsgrade;
                    $model_indigrade->courseid = $cceindigrade->courseid;
                    $model_indigrade->grade = $cceindigrade->grade;
                    $cceindold = Cceindicators::model()->findByPk($cceindigrade->cceindicatorid);
                    $cceindnew = Cceindicators::model()->findByAttributes(array('cceindicatordetails' => $cceindold->cceindicatordetails, 'academicid' => $academic->academicid));
                    $model_indigrade->cceindicatorid = $cceindnew->cceindicatorid;
                    $model_indigrade->cceskillid = $cceindnew->cceskillid;
                    $model_indigrade->academicid = $academic->academicid;
                    $model_indigrade->save(false);
                }
            }
            //! Cce exam scheme creation
            $cceex = Cceexamscheme::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceex)) {
                
            } else {
                $cceexa = Cceexamscheme::model()->find(array(
                    "order" => "cceexamschemeid DESC",
                    "limit" => 1,
                ));
                $cceexams = Cceexamscheme::model()->findAll('academicid=' . $cceexa->academicid);
                foreach ($cceexams as $cceexam) {
                    $model_cceexam = new Cceexamscheme;
                    $model_cceexam->courseid = $cceexam->courseid;
                    $model_cceexam->batchid = $cceexam->batchid;
                    $model_cceexam->examname = $cceexam->examname;
                    $cceassessold = Cceassessment::model()->findByPk($cceexam->cceassessmentid);
                    $cceassessnew = Cceassessment::model()->findByAttributes(array('cceassessmentname' => $cceassessold->cceassessmentname, 'cceassessmenttype' => $cceassessold->cceassessmenttype, 'academicid' => $academic->academicid));
                    $model_cceexam->cceassessmentid = $cceassessnew->cceassessmentid;
                    $model_cceexam->ccetermid = $cceexam->ccetermid;
                    $model_cceexam->academicid = $academic->academicid;
                    $model_cceexam->save(false);
                }
            }
            //! cce reportcard settings creation
            $ccerep = Ccereportcardsettings::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($ccerep)) {
                
            } else {
                $ccerepo = Ccereportcardsettings::model()->find(array(
                    "order" => "ccereportcardsettingsid DESC",
                    "limit" => 1,
                ));
                $ccereports = Ccereportcardsettings::model()->findAll('academicid=' . $ccerepo->academicid);
                foreach ($ccereports as $ccereport) {
                    $model_ccereport = new Ccereportcardsettings;
                    $model_ccereport->companyid = Yii::app()->user->companyid;
                    $model_ccereport->courseid = $ccereport->courseid;
                    $model_ccereport->template = $ccereport->template;
                    $model_ccereport->academicid = $academic->academicid;
                    $model_ccereport->save(false);
                }
            }
            //! Cce assign grade entries
            $cceassgr = Cceassigngrade::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($cceassgr)) {
                
            } else {
                $cceassgra = Cceassigngrade::model()->find(array(
                    "order" => "cceassigngradeid DESC",
                    "limit" => 1,
                ));
                $cceassgrades = Cceassigngrade::model()->findAll('academicid=' . $cceassgra->academicid);
                foreach ($cceassgrades as $cceassgrade) {
                    $model_cceassgrade = new Cceassigngrade;
                    $model_cceassgrade->companyid = Yii::app()->user->companyid;
                    $model_cceassgrade->courseid = $cceassgrade->courseid;
                    $model_cceassgrade->description = $cceassgrade->description;
                    $ccegradeold = Ccegrades::model()->findByPk($cceassgrade->ccegradesid);
                    $ccegradesetold = Ccegradeset::model()->findByPk($ccegradeold->ccegradesetid);
                    $ccegradesetnew = Ccegradeset::model()->findByAttributes(array('ccegradesetname' => $ccegradesetold->ccegradesetname, 'academicid' => $academic->academicid));
                    $ccegradenew = Ccegrades::model()->findByAttributes(array('ccegradesetid' => ccegradesetid, 'ccegradename' => $ccegradeold->ccegradename, 'academicid' => $academic->academicid));
                    $model_cceassgrade->ccegradesid = $ccegradenew->ccegradesid;
                    $model_cceassgrade->academicid = $academic->academicid;
                    $model_cceassgrade->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        if ($dataof === '4') { //! Salary details
            //! Salary settings creation
            $sal = Salarydetails::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($sal)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $sala = Salarydetails::model()->find(array(
                    "order" => "salarydetailsid DESC",
                    "limit" => 1,
                ));
                $salarydetails = Salarydetails::model()->findAll('academicid=' . $sala->academicid);
                foreach ($salarydetails as $salarydetail) {
                    $model_salary = new Salarydetails;
                    $model_salary->designationid = $salarydetail->designationid;
                    $model_salary->payheadmasterid = $salarydetail->payheadmasterid;
                    $model_salary->unit = $salarydetail->unit;
                    $model_salary->type = $salarydetail->type;
                    $model_salary->companyid = Yii::app()->user->companyid;
                    $model_salary->employeeid = $salarydetail->employeeid;
                    $model_salary->academicid = $academic->academicid;
                    $model_salary->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        if ($dataof === '5') { //! Finance 
            //! Fees category creation
            $feecat = Feescategory::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feecat)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $feecate = Feescategory::model()->find(array(
                    "order" => "feescategoryid DESC",
                    "limit" => 1,
                ));
                $feecategories = Feescategory::model()->findAll('academicid=' . $feecate->academicid);
                foreach ($feecategories as $feecategory) {
                    $model_feecategory = new Feescategory;
                    $model_feecategory->feescategory_name = $feecategory->feescategory_name;
                    $model_feecategory->feescategory_description = $feecategory->feescategory_description;
                    $model_feecategory->feescategory_receiptnoprefix = $feecategory->feescategory_receiptnoprefix;
                    $model_feecategory->companyid = Yii::app()->user->companyid;
                    $model_feecategory->academicid = $academic->academicid;
                    $model_feecategory->save(false);
                }
            }
            //! Fees sub category creation
            $feesubcat = Feessubcategory::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feesubcat)) {
                
            } else {
                $feesubcate = Feessubcategory::model()->find(array(
                    "order" => "feessubcategoryid DESC",
                    "limit" => 1,
                ));
                $feesubcategories = Feessubcategory::model()->findAll('academicid=' . $feesubcate->academicid);
                foreach ($feesubcategories as $feesubcategory) {
                    $model_subcategory = new Feessubcategory;
                    $feecatold = Feescategory::model()->findByPk($feesubcategory->feescategoryid);
                    $feecatnew = Feescategory::model()->findByAttributes(array('feescategory_name' => $feecatold->feescategory_name, 'academicid' => $academic->academicid));
                    $model_subcategory->feescategoryid = $feecatnew->feescategoryid;
                    $model_subcategory->feessubcategory_name = $feesubcategory->feessubcategory_name;
                    $model_subcategory->feessubcategory_amount = $feesubcategory->feessubcategory_amount;
                    $model_subcategory->payabletypeid = "";
                    $model_subcategory->companyid = Yii::app()->user->companyid;
                    $model_subcategory->excemption_deduction = $feesubcategory->excemption_deduction;
                    $model_subcategory->feestype = $feesubcategory->feestype;
                    $model_subcategory->category_gender = "";
                    $model_subcategory->categoryid = "";
                    $model_subcategory->gender = "";
                    $model_subcategory->deductionamountpercentage = "";
                    $model_subcategory->startdate = "";
                    $model_subcategory->enddate = "";
                    $model_subcategory->duedate = "";
                    $model_subcategory->academicid = $academic->academicid;
                    $model_subcategory->save(false);
                }
            }
            //! fees sub category dates creation
            $feeda = Feessubcategorydates::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feeda)) {
                
            } else {
                $feedat = Feessubcategorydates::model()->find(array(
                    "order" => "feessubcategorydatesid DESC",
                    "limit" => 1,
                ));
                $feedates = Feessubcategorydates::model()->findAll('academicid=' . $feedat->academicid);
                foreach ($feedates as $feedate) {
                    $model_feedate = new Feessubcategorydates;
                    $feesubcatold = Feessubcategory::model()->findByPk($feedate->feessubcategoryid);
                    $feecatold = Feescategory::model()->findByPk($feesubcatold->feescategoryid);
                    $feecatnew = Feescategory::model()->findByAttributes(array('feescategory_name' => $feecatold->feescategory_name, 'academicid' => $academic->academicid));
                    $feesubcatnew = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $feesubcatold->feessubcategory_name, 'feescategoryid' => $feecatnew->feescategoryid, 'academicid' => $academic->academicid));
                    $model_feedate->feessubcategoryid = $feesubcatnew->feessubcategoryid;
                    $model_feedate->start_date = $feedate->start_date;
                    $model_feedate->end_date = $feedate->end_date;
                    $model_feedate->due_date = $feedate->due_date;
                    $model_feedate->name = $feedate->name;
                    $model_feedate->academicid = $academic->academicid;
                    $model_feedate->save(false);
                }
            }
            //! Fee waiver creation
            $feew = Feewaiver::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feew)) {
                
            } else {
                $feewa = Feewaiver::model()->find(array(
                    "order" => "feewaiverid DESC",
                    "limit" => 1,
                ));
                $feewaivers = Feessubcategorydates::model()->findAll('academicid=' . $feewa->academicid);
                foreach ($feewaivers as $feewaiver) {
                    $model_feewaiver = new Feewaiver;
                    $feesubcatold = Feessubcategory::model()->findByPk($feewaiver->feessubcategoryid);
                    $feecatold = Feescategory::model()->findByPk($feesubcatold->feescategoryid);
                    $feecatnew = Feescategory::model()->findByAttributes(array('feescategory_name' => $feecatold->feescategory_name, 'academicid' => $academic->academicid));
                    $feesubcatnew = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $feesubcatold->feessubcategory_name, 'feescategoryid' => $feecatnew->feescategoryid, 'academicid' => $academic->academicid));
                    $model_feewaiver->feessubcategoryid = $feesubcatnew->feessubcategoryid;
                    $model_feewaiver->companyid = Yii::app()->user->companyid;
                    $model_feewaiver->excemption_deduction = $feewaiver->excemption_deduction;
                    $model_feewaiver->category_gender = $feewaiver->category_gender;
                    $model_feewaiver->categoryid = $feewaiver->categoryid;
                    $model_feewaiver->gender = $feewaiver->gender;
                    $model_feewaiver->deductionamountpercentage = $feewaiver->deductionamountpercentage;
                    $model_feewaiver->academicid = $academic->academicid;
                    $model_feewaiver->save(false);
                }
            }
            //! fees allocation creation
            $feeallo = Feesallocation::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feeallo)) {
                
            } else {
                $feealloc = Feesallocation::model()->find(array(
                    "order" => "feesallocationid DESC",
                    "limit" => 1,
                ));
                $feeallocations = Feesallocation::model()->findAll('academicid=' . $feealloc->academicid);
                foreach ($feeallocations as $feeallocation) {
                    $model_feealloc = new Feesallocation;
                    $feesubcatold = Feessubcategory::model()->findByPk($feeallocation->feessubcategoryid);
                    $feecatold = Feescategory::model()->findByPk($feesubcatold->feescategoryid);
                    $feecatnew = Feescategory::model()->findByAttributes(array('feescategory_name' => $feecatold->feescategory_name, 'academicid' => $academic->academicid));
                    $feesubcatnew = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $feesubcatold->feessubcategory_name, 'feescategoryid' => $feecatnew->feescategoryid, 'academicid' => $academic->academicid));
                    $model_feealloc->feessubcategoryid = $feesubcatnew->feessubcategoryid;
                    $model_feealloc->studentid = $feeallocation->studentid;
                    $model_feealloc->companyid = Yii::app()->user->companyid;
                    $model_feealloc->feesfor = $feeallocation->feesfor;
                    $model_feealloc->courseid = $feeallocation->courseid;
                    $model_feealloc->batchid = $feeallocation->batchid;
                    $model_feealloc->date = $feeallocation->date;
                    $model_feealloc->academicid = $academic->academicid;

                    if ($feeallocation->feesfor === '1') { //! all batches
                        $students = Student::model()->findAll();
                        foreach ($students as $student) {
                            if ($student->courseid != "" && $student->batchid != "") {
                                $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $student->studentid, 'companyid' => Yii::app()->user->companyid, 'academicid' => $academic->academicid));
                                if (isset($feestruc)) {
                                    $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $feesubcatnew->feessubcategoryid . ",";
                                    $feestruc->save(false);
                                } else {
                                    $modelf = new Studentfeesstructure;
                                    $modelf->studentid = $student->studentid;
                                    $modelf->feessubcategoryid = $feesubcatnew->feessubcategoryid . ",";
                                    $modelf->companyid = Yii::app()->user->companyid;
                                    $modelf->academicid = $academic->academicid;
                                    $modelf->save(false);
                                }
                            }
                        }
                    }
                    if ($feeallocation->feesfor === '2') { //! selected batch
                        $students = Student::model()->findAllByAttributes(array('batchid' => $feeallocation->batchid));
                        foreach ($students as $student) {
                            if ($student->courseid != "" && $student->batchid != "") {
                                $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $student->studentid, 'companyid' => Yii::app()->user->companyid, 'academicid' => $academic->academicid));
                                if (isset($feestruc)) {
                                    $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $feesubcatnew->feessubcategoryid . ",";
                                    $feestruc->save(false);
                                } else {
                                    $modelf = new Studentfeesstructure;
                                    $modelf->studentid = $student->studentid;
                                    $modelf->feessubcategoryid = $feesubcatnew->feessubcategoryid . ",";
                                    $modelf->companyid = Yii::app()->user->companyid;
                                    $modelf->academicid = $academic->academicid;
                                    $modelf->save(false);
                                }
                            }
                        }
                    }
                    if ($feeallocation->feesfor === '3') { //! Selected student
                        $feestruc = Studentfeesstructure::model()->findByAttributes(array('studentid' => $feeallocation->studentid, 'companyid' => Yii::app()->user->companyid, 'academicid' => $academic->academicid));
                        if (isset($feestruc)) {
                            $feestruc->feessubcategoryid = $feestruc->feessubcategoryid . $feesubcatnew->feessubcategoryid . ",";

                            $feestruc->save(false);
                        } else {
                            $modelf = new Studentfeesstructure;
                            $modelf->studentid = $feeallocation->studentid;
                            $modelf->feessubcategoryid = $feesubcatnew->feessubcategoryid . ",";
                            $modelf->companyid = Yii::app()->user->companyid;
                            $modelf->academicid = $academic->academicid;
                            $modelf->save(false);
                        }
                    }
                    $model_feealloc->save(false);
                }
            }
            //! fee payment details (one time payment)
            $feep = Feepaymentdetails::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($feep)) {
                
            } else {
                $feepa = Feepaymentdetails::model()->find(array(
                    "order" => "feepaymentdetailsid DESC",
                    "limit" => 1,
                ));
                $feesubcategories = Feessubcategory::model()->findAll('academicid=' . $feepa->academicid);
                foreach ($feesubcategories as $feesubcategory) {
                    if ($feessubcategory->feestype === '6') { //! checks if feestype is one time fee
                        $payments = Feepaymentdetails::model()->findAllByAttributes(array('feessubcategoryid' => $feessubcategory->feessubcategoryid, 'academicid' => $feepa->academicid));
                        foreach ($payments as $payment) {
                            $model_payment = new Feepaymentdetails;
                            $feesubcatold = Feessubcategory::model()->findByPk($payment->feessubcategoryid);
                            $feecatold = Feescategory::model()->findByPk($feesubcatold->feescategoryid);
                            $feecatnew = Feescategory::model()->findByAttributes(array('feescategory_name' => $feecatold->feescategory_name, 'academicid' => $academic->academicid));
                            $feesubcatnew = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $feesubcatold->feessubcategory_name, 'feescategoryid' => $feecatnew->feescategoryid, 'academicid' => $academic->academicid));
                            $model_payment->feessubcategoryid = $feesubcatnew->feessubcategoryid;
                            $model_payment->feescategoryid = $feecatnew->feescategoryid;
                            $model_payment->studentid = $payment->studentid;
                            $model_payment->courseid = $payment->courseid;
                            $model_payment->batchid = $payment->batchid;
                            $model_payment->amount = $payment->amount;
                            $model_payment->status = $payment->status;
                            $model_payment->modeofpay = $payment->modeofpay;
                            $model_payment->fine = $payment->fine;
                            $model_payment->discount = $payment->discount;
                            $model_payment->bankname = $payment->bankname;
                            $model_payment->chequeno = $payment->chequeno;
                            $model_payment->chequedate = $payment->chequedate;
                            $model_payment->remarks = $payment->remarks;
                            $model_payment->paiddate = $payment->paiddate;
                            $model_payment->receiptno = $payment->receiptno;
                            $feedold = Feessubcategorydates::model()->findByPk($payment->feessubcategorydatesid);
                            $feednew = Feessubcategorydates::model()->findByAttributes(array('name' => $feedold->name, 'feessubcategoryid' => $feesubcatnew->feessubcategoryid, 'academicid' => $academic->academicid));
                            $model_payment->feescategoryid = $feednew->feessubcategorydatesid;
                            $model_payment->academicid = $academic->academicid;
                            $model_payment->save(false);
                        }
                    }
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        if ($dataof === '6') { //! Transport details 
            //! route details
            $route = Routemaster::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($route)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $routed = Routemaster::model()->find(array(
                    "order" => "routemasterid DESC",
                    "limit" => 1,
                ));
                $routemasters = Routemaster::model()->findAll('academicid=' . $routed->academicid);
                foreach ($routemasters as $routemaster) {
                    $model_routemaster = new Routemaster;
                    $model_routemaster->companyid = Yii::app()->user->companyid;
                    $model_routemaster->routemaster_code = $routemaster->routemaster_code;
                    $model_routemaster->routemasterr_stopname = $routemaster->routemasterr_stopname;
                    $model_routemaster->routemaster_startname = $routemaster->routemaster_startname;
                    $model_routemaster->transportvehicleid = $routemaster->transportvehicleid;
                    $model_routemaster->academicid = $academic->academicid;
                    $model_routemaster->save(false);
                }
            }
            //! Destination Details
            $rout = Routedetails::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($rout)) {
                
            } else {
                $routede = Routedetails::model()->find(array(
                    "order" => "routedetailsid DESC",
                    "limit" => 1,
                ));
                $routedetails = Routedetails::model()->findAll('academicid=' . $routede->academicid);
                foreach ($routedetails as $routedetail) {
                    $model_routedetail = new Routedetails;
                    $routemasterold = Routemaster::model()->findByPk($routedetail->routemasterid);
                    $routemasternew = Routemaster::model()->findByAttributes(array('routemaster_code' => $routemasterold->routemaster_code, 'academicid' => $academic->academicid));
                    $model_routedetail->routemasterid = $routemasternew->routemasterid;
                    $model_routedetail->routedetails_rate = $routedetail->routedetails_rate;
                    $model_routedetail->routedetails_stopposition = $routedetail->routedetails_stopposition;
                    $model_routedetail->routedetails_stoptime = $routedetail->routedetails_stoptime;
                    $model_routedetail->feestype = $routedetail->feestype;
                    $model_routedetail->academicid = $academic->academicid;
                    $model_routedetail->save(false);
                }
            }
            //! Transport fee dates details
            $trfeed = Transportfeedates::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($trfeed)) {
                
            } else {
                $trfeedat = Transportfeedates::model()->find(array(
                    "order" => "transportfeedatesid DESC",
                    "limit" => 1,
                ));
                $trfeedates = Routedetails::model()->findAll('academicid=' . $trfeedat->academicid);
                foreach ($trfeedates as $trfeedate) {
                    $model_trfeedate = new Transportfeedates;
                    $destinationold = Routedetails::model()->findByPk($trfeedate->routedetailsid);
                    $routeold = Routemaster::model()->findByPk($destinationold->routemasterid);
                    $routenew = Routemaster::model()->findByAttributes(array('routemaster_code' => $routeold->routemaster_code, 'academicid' => $academic->academicid));
                    $destinationnew = Routedetails::model()->findByAttributes(array('routedetails_stopposition' => $destinationold->routedetails_stopposition, 'routemasterid' => $routenew->routemasterid, 'academicid' => $academic->academicid));
                    $model_trfeedate->routedetailsid = $destinationnew->routedetailsid;
                    $model_trfeedate->start_date = $trfeedate->start_date;
                    $model_trfeedate->end_date = $trfeedate->end_date;
                    $model_trfeedate->due_date = $trfeedate->due_date;
                    $model_trfeedate->name = $trfeedate->name;
                    $model_trfeedate->academicid = $academic->academicid;
                    $model_trfeedate->save(false);
                }
            }
            //! Transport allocation details creation
            $trfeealloc = Transportallocation::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($trfeealloc)) {
                
            } else {
                $trfeealloca = Transportallocation::model()->find(array(
                    "order" => "transportallocationid DESC",
                    "limit" => 1,
                ));
                $trfeeallocations = Transportallocation::model()->findAll('academicid=' . $trfeealloca->academicid);
                foreach ($trfeeallocations as $trfeeallocation) {
                    $model_trfeeallocation = new Transportallocation;
                    $destinationold = Routedetails::model()->findByPk($trfeedate->routedetailsid);
                    $routeold = Routemaster::model()->findByPk($destinationold->routemasterid);
                    $routenew = Routemaster::model()->findByAttributes(array('routemaster_code' => $routeold->routemaster_code, 'academicid' => $academic->academicid));
                    $destinationnew = Routedetails::model()->findByAttributes(array('routedetails_stopposition' => $destinationold->routedetails_stopposition, 'routemasterid' => $routenew->routemasterid, 'academicid' => $academic->academicid));
                    $model_trfeeallocation->routemasterid = $destinationnew->routemasterid;
                    $model_trfeeallocation->routedetailsid = $destinationnew->routedetailsid;
                    $model_trfeeallocation->usertypeid = $trfeeallocation->usertypeid;
                    $model_trfeeallocation->userid = $trfeeallocation->userid;
                    $model_trfeeallocation->transportallocation_startdate = $trfeeallocation->transportallocation_startdate;
                    $model_trfeeallocation->transportallocation_enddate = $trfeeallocation->transportallocation_enddate;
                    $model_trfeeallocation->academicid = $academic->academicid;
                    $model_trfeeallocation->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        if ($dataof === '7') {  //! Hostel details
            //! hostel room details creation
            $hstlrm = Hostelroom::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($hstlrm)) {
                Yii::app()->user->setFlash('error', 'Data already exist.');
            } else {
                $hstlroom = Hostelroom::model()->find(array(
                    "order" => "hostelroomid DESC",
                    "limit" => 1,
                ));
                $hostelrooms = Hostelroom::model()->findAll('academicid=' . $hstlroom->academicid);
                foreach ($hostelrooms as $hostelroom) {
                    $model_hostelroom = new Hostelroom;
                    $model_hostelroom->hosteldetailsid = $hostelroom->hosteldetailsid;
                    $model_hostelroom->hostelroom_roomno = $hostelroom->hostelroom_roomno;
                    $model_hostelroom->hosteltypeid = $hostelroom->hosteltypeid;
                    $model_hostelroom->feestype = $hostelroom->feestype;
                    $model_hostelroom->hostelroom_floorname = $hostelroom->hostelroom_floorname;
                    $model_hostelroom->hostelroom_noofbeds = $hostelroom->hostelroom_noofbeds;
                    $model_hostelroom->hostelroom_rent = $hostelroom->hostelroom_rent;
                    $model_hostelroom->companyid = Yii::app()->user->companyid;
                    $model_hostelroom->academicid = $academic->academicid;
                    $model_hostelroom->save(false);
                }
            }
            //! hostel fee dates creation
            $hstlfee = Hostelfeedates::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($hstlfee)) {
                
            } else {
                $hstlfeed = Hostelfeedates::model()->find(array(
                    "order" => "hostelfeedatesid DESC",
                    "limit" => 1,
                ));
                $hstlfeedates = Hostelfeedates::model()->findAll('academicid=' . $hstlfeed->academicid);
                foreach ($hstlfeedates as $hstlfeedate) {
                    $model_hstlfeedate = new Hostelfeedates;
                    $roomold = Hostelroom::model()->findByPk($hstlfeedate->hostelroomid);
                    $roomnew = Hostelroom::model()->findByAttributes(array('hostelroom_roomno' => $roomold->hostelroom_roomno, 'hostelroom_floorname' => $roomold->hostelroom_floorname, 'academicid' => $academic->academicid));
                    $model_hstlfeedate->hostelroomid = $roomnew->hostelroomid;
                    $model_hstlfeedate->name = $hstlfeedate->name;
                    $model_hstlfeedate->companyid = Yii::app()->user->companyid;
                    $model_hstlfeedate->start_date = $hstlfeedate->start_date;
                    $model_hstlfeedate->end_date = $hstlfeedate->end_date;
                    $model_hstlfeedate->due_date = $hstlfeedate->due_date;
                    $model_hstlfeedate->academicid = $academic->academicid;
                    $model_hstlfeedate->save(false);
                }
            }
            //! Hostel allocation details
            $hstlre = Hostelregistration::model()->findByAttributes(array('academicid' => $academic->academicid));
            if (isset($hstlre)) {
                
            } else {
                $hstlreg = Hostelregistration::model()->find(array(
                    "order" => "hostelregistrationid DESC",
                    "limit" => 1,
                ));
                $hstlregistrations = Hostelregistration::model()->findAll('academicid=' . $hstlreg->academicid);
                foreach ($hstlregistrations as $hstlregistration) {
                    $model_hstlregistration = new Hostelregistration;
                    $model_hstlregistration->companyid = Yii::app()->user->companyid;
                    $model_hstlregistration->usertypeid = $hstlregistration->usertypeid;
                    $roomold = Hostelroom::model()->findByPk($hstlregistration->hostelroomid);
                    $roomnew = Hostelroom::model()->findByAttributes(array('hostelroom_roomno' => $roomold->hostelroom_roomno, 'hostelroom_floorname' => $roomold->hostelroom_floorname, 'academicid' => $academic->academicid));
                    $model_hstlregistration->hostelroomid = $roomnew->hostelroomid;
                    $model_hstlregistration->userid = $hstlregistration->userid;
                    $model_hstlregistration->vacatingdate = $hstlregistration->vacatingdate;
                    $model_hstlregistration->hostelregistration_date = $hstlregistration->hostelregistration_date;
                    $model_hstlregistration->hostelregistration_status = $hstlregistration->hostelregistration_status;
                    $model_hstlregistration->hosteldetailsid = $hstlregistration->hosteldetailsid;
                    $model_hstlregistration->academicid = $academic->academicid;
                    $model_hstlregistration->save(false);
                }
                Yii::app()->user->setFlash('success', 'You are successfully migrated the previous year data.');
            }
        }
        $this->redirect(array('core/academic/create'));
    }

    /*
     * A Function
     * Used for reset all datas with active academicyear
     */

//    public function actionResetdata() {
//        $this->render('resetdata');
//    }

    /*
     * A function
     * Used for import library book details
     */

    public function actionLibraryimport() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $uploadedFile = CUploadedFile::getInstance($model, 'filea');
            if ($uploadedFile == "") {
                Yii::app()->user->setFlash('error', 'Please select a file.');
            } else {
                $allowed = array('xlsx');
                $filename = CUploadedFile::getInstance($model, 'filea');
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    throw new CHttpException(404, 'File extension error. The allowed extension is xlsx.');
                    exit(0);
                } else {

                    $ext = end((explode(".", $uploadedFile)));
                    $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                    $date = new DateTime();
                    $date->setTimezone($timezone);
                    $date = $date->format('dmYhis');
                    $fileName = "{$date}.{$ext}";
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                    //reading portion : here each column is read row and column wise; please check the sample
                    //import file to get the column format. The heading row can be kept. The heading is ignored
                    //while reading the excel or csv file.

                    $sheet_array = Yii::app()->yexcel->readActiveSheet(Yii::app()->basePath . '/../banner/' . $fileName);
                    $count = 0;
                    foreach ($sheet_array as $row) {
                        $count = $count + 1;
                    }
                    for ($x = 2; $x <= $count; $x++) {
                        try {
                            if (
                                    ( $sheet_array[$x]['A'] == "" || $sheet_array[$x]['A'] == " ") &&
                                    ( $sheet_array[$x]['B'] == "" || $sheet_array[$x]['B'] == " ") &&
                                    ( $sheet_array[$x]['C'] == "" || $sheet_array[$x]['C'] == " ") &&
                                    ( $sheet_array[$x]['D'] == "" || $sheet_array[$x]['D'] == " ") &&
                                    ( $sheet_array[$x]['E'] == "" || $sheet_array[$x]['E'] == " ") &&
                                    ( $sheet_array[$x]['F'] == "" || $sheet_array[$x]['F'] == " ") &&
                                    ( $sheet_array[$x]['G'] == "" || $sheet_array[$x]['G'] == " ") &&
                                    ( $sheet_array[$x]['H'] == "" || $sheet_array[$x]['H'] == " ") &&
                                    ( $sheet_array[$x]['I'] == "" || $sheet_array[$x]['I'] == " ") &&
                                    ( $sheet_array[$x]['J'] == "" || $sheet_array[$x]['J'] == " ") &&
                                    ( $sheet_array[$x]['K'] == "" || $sheet_array[$x]['K'] == " ") &&
                                    ( $sheet_array[$x]['L'] == "" || $sheet_array[$x]['L'] == " ")
                            ) {
                                break;
                                //$this->redirect(array('/library/librarybooks/create'), array('message' => 'Successfuly Updated!'));
                            }
                            if ($sheet_array[$x]['H'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field no of copies validation error');
                                exit(0);
                            } else {
                                $bookcopies = $sheet_array[$x]['H'];
                                for ($i = 1; $i <= $bookcopies; $i = $i + 1) {

                                    $librarybooks = new Librarybooks;
                                    $librarybooks->librarybooks_isbn = $sheet_array[$x]['A'];

                                    if ($sheet_array[$x]['B'] == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field book no validation error');
                                        exit(0);
                                    } else {
                                        $librarybooks->librarybooks_lbookno = $sheet_array[$x]['B'] . $i;
                                    }

                                    if ($sheet_array[$x]['C'] == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field title validation error');
                                        exit(0);
                                    } else {
                                        $librarybooks->librarybooks_title = $sheet_array[$x]['C'];
                                    }

                                    if ($sheet_array[$x]['D'] == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field author validation error');
                                        exit(0);
                                    } else {
                                        $librarybooks->librarybooks_author = $sheet_array[$x]['D'];
                                    }

//                            if ($sheet_array[$x]['E'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field edition validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_edition = $sheet_array[$x]['E'];
//                            }

                                    $category = Bookcategory::model()->findByAttributes(array('bookcategory_name' => $sheet_array[$x]['F']));
                                    if ($category == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field Bookcategory validation error');
                                        exit(0);
                                    } else {
                                        $librarybooks->bookcategoryid = $category->bookcategoryid;
                                    }
//                            if ($sheet_array[$x]['G'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field publisher validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_publisher = $sheet_array[$x]['G'];
//                                }
                                    if ($sheet_array[$x]['H'] == "") {
                                        throw new CHttpException(404, 'Row number :' . $x . 'The field no of copies validation error');
                                        exit(0);
                                    } else {
                                        $librarybooks->librarybooks_noofcopies = $sheet_array[$x]['H'];
                                    }
//                            if ($sheet_array[$x]['I'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field shelf no validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_shelfno = $sheet_array[$x]['I'];
//                            }
//                            if ($sheet_array[$x]['J'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field book position validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_bookposition = $sheet_array[$x]['J'];
//                            }
//                            if ($sheet_array[$x]['K'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field book cost validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_cost = $sheet_array[$x]['K'];
//                            }
//                            if ($sheet_array[$x]['L'] == "") {
//                                throw new CHttpException(404, 'Row number :' . $x . 'The field language validation error');
//                                exit(0);
//                            } else {
                                    $librarybooks->librarybooks_language = $sheet_array[$x]['L'];
//                            }
                                    $librarybooks->companyid = Yii::app()->user->companyid;
                                    $librarybooks->status = 1;  //! Status:1 Available books
                                    $librarybooks->condition = 1; //! Book condition is "as new".


                                    $librarybooks->save(false);
                                }
                            }


                            // $usertype = $usertype->usertypeid;
                        } catch (CDbException $e) {
                            throw new CHttpException(404, 'Something went wrong while uploading your excel file.');
                        }
                    }
//                $this->render('contact_emp', array('model' => $model, 'message' => 'Successfuly Updated!'));
                    if ($x == 2) {
                        $this->render('contact_lib', array('model' => $model, 'message' => 'The file you uploaded is empty.!'));
                    } else {
                        $this->redirect(array('/library/librarybooks/create'), array('message' => 'Successfuly Updated!'));
                    }
                }
            }
        }

        $this->render('contact_lib', array('model' => $model, 'message' => ''));
    }

    /*
     * A function
     * Used for import fees details
     */

    public function actionFeeimport() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $uploadedFile = CUploadedFile::getInstance($model, 'filea');
            if ($uploadedFile == "") {
                Yii::app()->user->setFlash('error', 'Please select a file.');
            } else {
                $allowed = array('xlsx', 'xls');
                $filename = CUploadedFile::getInstance($model, 'filea');
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    throw new CHttpException(404, 'File extension error. The allowed extension is xlsx.');
                    exit(0);
                } else {

                    $ext = end((explode(".", $uploadedFile)));
                    $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                    $date = new DateTime();
                    $date->setTimezone($timezone);
                    $date = $date->format('dmYhis');
                    $fileName = "{$date}.{$ext}";
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                    //reading portion : here each column is read row and column wise; please check the sample
                    //import file to get the column format. The heading row can be kept. The heading is ignored
                    //while reading the excel or csv file.

                    $sheet_array = Yii::app()->yexcel->readActiveSheet(Yii::app()->basePath . '/../banner/' . $fileName);
                    $count = 0;
                    foreach ($sheet_array as $row) {
                        $count = $count + 1;
                    }
                    for ($x = 2; $x <= $count; $x++) {

                        try {
                            if (
                                    ($sheet_array[$x]['A'] == "" || $sheet_array[$x]['A'] == " ") &&
                                    ($sheet_array[$x]['B'] == "" || $sheet_array[$x]['B'] == " ") &&
                                    ($sheet_array[$x]['C'] == "" || $sheet_array[$x]['C'] == " ") &&
                                    ($sheet_array[$x]['D'] == "" || $sheet_array[$x]['D'] == " ") &&
                                    ($sheet_array[$x]['E'] == "" || $sheet_array[$x]['E'] == " ") &&
                                    ($sheet_array[$x]['H'] == "" || $sheet_array[$x]['H'] == " ") &&
                                    ($sheet_array[$x]['I'] == "" || $sheet_array[$x]['I'] == " ") &&
                                    ($sheet_array[$x]['J'] == "" || $sheet_array[$x]['J'] == " ")
                            ) {
                                break;
//                                $this->redirect(array('/core/feesallocation/paidreport'), array('message' => 'Successfuly Updated!'));
                            }
                            $feeimports = new Feepaymentdetails;

                            $adm_no = Student::model()->findByAttributes(array('student_admissionno' => $sheet_array[$x]['A']));

                            if ($sheet_array[$x]['A'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field student admission number validation error');
                                exit(0);
                            } elseif ($adm_no == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'Student admission number does not exist.');
                                exit(0);
                            } else {
                                $studentid = $adm_no->studentid;
                                $feeimports->studentid = $studentid;
                            }

                            $course = Course::model()->findByAttributes(array('course_name' => $sheet_array[$x]['B']));
                            if ($course == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field course validation error');
                                exit(0);
                            } else {

                                $feeimports->courseid = $course->courseid;
                            }
                            $batch = Batch::model()->findByAttributes(array('batch_name' => $sheet_array[$x]['C'], 'courseid' => $course->courseid));
                            if ($batch == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field batch validation error');
                                exit(0);
                            } else {
                                $feeimports->batchid = $batch->batchid;
                            }

                            $academic = Academic::model()->findByAttributes(array('status' => 1));  //! $academic stores active academic year details
                            $feecategory = Feescategory::model()->findByAttributes(array('feescategory_name' => $sheet_array[$x]['D'], 'academicid' => $academic->academicid));
                            if ($feecategory == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field fees category validation error');
                                exit(0);
                            } else {

                                $feeimports->feescategoryid = $feecategory->feescategoryid;
                            }
                            $feesubcategory = Feessubcategory::model()->findByAttributes(array('feessubcategory_name' => $sheet_array[$x]['E'],
                                'feescategoryid' => $feecategory->feescategoryid, 'academicid' => $academic->academicid));
                            if ($feesubcategory == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field fee sub category validation error');
                                exit(0);
                            } else {
                                $feeimports->feessubcategoryid = $feesubcategory->feessubcategoryid;
                            }

                            $feetype = Feessubcategorydates::model()->findByAttributes(array('name' => $sheet_array[$x]['G'],
                                'feessubcategoryid' => $feesubcategory->feessubcategoryid, 'academicid' => $academic->academicid));

                            if ($feetype == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field fee fee type validation error');
                                exit(0);
                            } else {
                                $feeimports->feessubcategorydatesid = $feetype->feessubcategorydatesid;
                            }

                            if ($sheet_array[$x]['H'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field fee paid date validation error');
                                exit(0);
                            } else {
                                $date3 = date_create($sheet_array[$x]['H']);
                                $paiddate = date_format($date3, 'Y-m-d');
                                $feeimports->paiddate = $paiddate;
                            }

                            if ($sheet_array[$x]['I'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field amount validation error');
                                exit(0);
                            } else {
                                $feeimports->amount = $sheet_array[$x]['I'];
                            }
                            $feeimports->fine = $sheet_array[$x]['J'];
                            $feeimports->remarks = $sheet_array[$x]['K'];
                            $feeimports->discount = $sheet_array[$x]['L'];

                            $feeimports->status = 1;
                            $feeimports->modeofpay = 0;

                            //  $feeimports->discount= $sheet_array[$x]['L'];

                            $feeimports->save(false);
                        } catch (CDbException $e) {
                            throw new CHttpException(404, 'Something went wrong while uploading your excel file.');
                        }
                    }
                    if ($x == 2) {
                        $this->render('contact_fee', array('model' => $model, 'message' => 'The file you uploaded is empty.!'));
                    } else {
                        $this->redirect(array('/core/feesallocation/paidreport'), array('message' => 'Successfuly Updated!'));
                    }
                }
            }
        }

        $this->render('contact_fee', array('model' => $model, 'message' => ''));
    }

    /*
     * A function
     * Used for viewing dataexport page
     */

    public function actionDataexport() {
        $this->render('dataexport');
    }

    /*
     * A function
     * Used for creating excel sheet
     */

    public function actionCreateExcel() {
        Yii::import('ext.phpexcel.XPHPExcel');
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        if ($_POST['exportfor'] === '1') { //! Student details like attendance, exam, fee details
            $courseid = $_POST['courseid'];
            $studentexportdetails = $_POST['studentexportdetails'];

            if ($studentexportdetails === '1') { //! Attendance details
                $studentarray = array();
                $course = Course::model()->findByPk($courseid); //! $course stores course details
//                if ($course->attendancetype == "0") { //! Check whether the attendenace type is daily attendance. If yes,
                $batches = Batch::model()->findAllByAttributes(array('courseid' => $courseid));
                $i = 0;
                foreach ($batches as $batch) {
                    $batchid = $batch->batchid;
                    $objPHPExcel->createSheet($i); //Setting index when creating
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Student Name');
                    for ($j = 1; $j <= 31; $j = $j + 1) {
                        $month = $j;

                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B1', 'January');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C1', 'February');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D1', 'March');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E1', 'April');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F1', 'May');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G1', 'June');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H1', 'July');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I1', 'August');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J1', 'September');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K1', 'October');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L1', 'November');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M1', 'December');

                        if ($month === 1) {
                            $sheetno = 'B';
                        }
                        if ($month === 2) {
                            $sheetno = 'C';
                        }
                        if ($month === 3) {
                            $sheetno = 'D';
                        }
                        if ($month === 4) {
                            $sheetno = 'E';
                        }
                        if ($month === 5) {
                            $sheetno = 'F';
                        }
                        if ($month === 6) {
                            $sheetno = 'G';
                        }
                        if ($month === 7) {
                            $sheetno = 'H';
                        }
                        if ($month === 8) {
                            $sheetno = 'I';
                        }
                        if ($month === 9) {
                            $sheetno = 'J';
                        }
                        if ($month === 10) {
                            $sheetno = 'K';
                        }
                        if ($month === 11) {
                            $sheetno = 'L';
                        }
                        if ($month === 12) {
                            $sheetno = 'M';
                        }

                        $students = Student::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batchid));
                        $leavedays = array();
                        $k = 2;
                        foreach ($students as $student) {//! < For each students,
                            $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;

                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $k, $studentname);

                            $attendance = Studentabsent::model()->findAllByAttributes(array('studentid' => $student->studentid)); //! << $attendance selected student's attendance details
                            foreach ($attendance as $perday) {//! << For each attendance,
                                $readmonth = $perday->date;
                                $date = new DateTime($readmonth);
                                $readmonth = $date->format('m');
                                $readmonth = (int) $readmonth; //! <<< $readmonth stores the month of each attendance 
                                if ($readmonth === $month) {//! <<< Check whether the selected month is equal to $readmonth. If yes,
                                    $studentname = Student::model()->findByPk($perday->studentid); //! <<<< $studentname stores the student details

                                    if (in_array($studentname->student_admissionno, $studentarray)) {//! <<<< Chcek whether the student attendance details are already stored.
                                    } else {
                                        array_push($studentarray, $studentname->student_admissionno);
                                        //! <<<<< Student admission number is pushed in to array.

                                        for ($n = 1; $n <= 31; $n++) {//! <<<<< For each date check whether the student is present or not
                                            $date1 = date_create($month . '/' . $n . '/' . date('Y'));
                                            $date2 = date_format($date1, 'Y-m-d H:i:s');

                                            $checkattendance = Studentabsent::model()->findByAttributes(array('studentid' => $perday->studentid, 'date' => $date2));
                                            $date3 = date_format($date1, 'Y-m-d');
                                            $event = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '2', 'courseid' => $courseid, 'batchid' => $batchid));
                                            $event2 = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '1'));

                                            if (isset($checkattendance)) {//! <<<<<< If student is present 'X' is passed to form
                                            } else {//! <<<<<< If student is not present, 
                                                $Datetime_acdate = strtotime($date2);
                                                $DayofWeek = date('D', $Datetime_acdate);
                                                if ($DayofWeek == 'Sun') {//! <<<<<<< Check whether the day is sunday. If yes 'S' is paased to form
                                                } else if (isset($event)) {//! <<<<<<< If it is not sunday, then check whether any event on that day. If yes, 'H' passed to form. Other wise 'A' is passed to form
                                                    $events = Event::model()->findAllByAttributes(array('isholiday' => '1', 'courseid' => $courseid, 'batchid' => $batchid, 'event_for' => '2'));
                                                    foreach ($events as $eachevent) {

                                                        $eventstartdate = $eachevent->event_start;
                                                        $startdate1 = explode(' ', $eventstartdate);
                                                        $startdate = $startdate1[0];
                                                        $startdate1 = date_create($startdate);
                                                        $startdate2 = date_format($startdate1, 'Y-m-d');

                                                        $eventenddate = $eachevent->event_end;
                                                        $enddate3 = explode(' ', $eventenddate);
                                                        $enddate = $enddate3[0];
                                                        $enddate1 = date_create($enddate);
                                                        $enddate2 = date_format($enddate1, 'Y-m-d');

                                                        $startday = explode('-', $startdate2);
                                                        $endday = explode('-', $enddate2);
                                                        $startday1 = $startday[2];
                                                        $endday1 = $endday[2];

                                                        $holidays = array();
                                                        for ($m = $startday1; $m <= $endday1; $m++) {
                                                            $date1 = date_create($startday[1] . '/' . $m . '/' . $startday[0]);
                                                            $date4 = date_format($date1, 'Y-m-d');
                                                            array_push($holidays, $date4);
                                                        }
                                                    }

                                                    if (in_array($date3, $holidays)) {
                                                        
                                                    } else {
                                                        // count of leave days
                                                        array_push($leavedays, $date3);
                                                    }
                                                } else if (isset($event2)) {
                                                    $events1 = Event::model()->findAllByAttributes(array('isholiday' => '1', 'event_for' => '1'));
                                                    foreach ($events1 as $eachevent1) {

                                                        $eventstartdate = $eachevent1->event_start;
                                                        $startdate11 = explode(' ', $eventstartdate);
                                                        $startdate1 = $startdate11[0];
                                                        $startdate11 = date_create($startdate1);
                                                        $startdate21 = date_format($startdate11, 'Y-m-d');

                                                        $eventenddate = $eachevent1->event_end;
                                                        $enddate31 = explode(' ', $eventenddate);
                                                        $enddate1 = $enddate31[0];
                                                        $enddate11 = date_create($enddate1);
                                                        $enddate21 = date_format($enddate11, 'Y-m-d');

                                                        $startday1 = explode('-', $startdate21);
                                                        $endday1 = explode('-', $enddate21);
                                                        $startday11 = $startday1[2];
                                                        $endday11 = $endday1[2];

                                                        $holidays1 = array();
                                                        for ($m1 = $startday11; $m1 <= $endday11; $m1++) {
                                                            $date11 = date_create($startday1[1] . '/' . $m1 . '/' . $startday1[0]);
                                                            $date41 = date_format($date11, 'Y-m-d');
                                                            array_push($holidays1, $date41);
                                                        }
                                                    }
                                                    if (in_array($date3, $holidays1)) {
                                                        
                                                    } else {
                                                        // count of leave days
                                                        array_push($leavedays, $date3);
                                                    }
                                                } else {
                                                    // count of leave days
                                                    array_push($leavedays, $date3);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
//                            $leavedays = array_unique($leavedays);
                            $count = count($leavedays);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue($sheetno . $k, $count);
                            $k++;
                            $leavedays = array();
                        }
                    }
                    $i++;
                    // Rename worksheet
                    $objPHPExcel->getActiveSheet()->setTitle($course->course_name . " - " . $batch->batch_name);
                }
                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = $course->course_name . "_attendance_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
//                }
            }
            /**             * *************************************************************************** */
            if ($studentexportdetails === '2') { //! Exam details
                $studentarray = array();
                $course = Course::model()->findByPk($courseid); //! $course stores course details
                $batches = Batch::model()->findAllByAttributes(array('courseid' => $courseid));
                $syllabus = Syllabus::model()->findByAttributes(array('courseid' => $courseid));
                if ($syllabus->syllabus_name === "GPA") {
                    $i = 0;
                    foreach ($batches as $batch) {
                        $batchid = $batch->batchid;
                        $objPHPExcel->createSheet($i); //Setting index when creating

                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Student Name');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B1', 'Term');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C1', 'Exam');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D1', 'Subject');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E1', 'Max.Mark');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F1', 'Pass.Mark');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G1', 'Mark');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H1', 'Exam Date');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I1', 'Start Time');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J1', 'End Time');


                        $setmarklists = Setmarklist::model()->findAll();
                        $j = 2;
                        foreach ($setmarklists as $setmark) {
                            $student = Student::model()->findByPk($setmark->studentid);
                            $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;
                            if ($student->batchid === $batchid && $student->courseid === $courseid) {
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $j, $studentname);

                                $setexam = Setexam::model()->findByAttributes(array('courseid' => $student->courseid, 'batchid' => $student->batchid, 'examid' => $setmark->examid, 'subjectid' => $setmark->subjectid));
                                if (isset($setexam)) {
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $j, $setexam->term->term_name);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $j, $setexam->exam->exam_name);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $j, $setexam->subject->subject_code . " - " . $setexam->subject->subject_name);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $j, $setexam->setexam_maxmark);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $j, $setexam->setexam_passmark);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $j, $setmark->setmarklist_mark);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H' . $j, $setexam->setexam_date);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I' . $j, $setexam->setexam_starttime);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J' . $j, $setexam->setexam_endtime);
                                }
                                $j++;
                            }
                        }

                        $styleArray = array(
                            'font' => array(
                                'bold' => true,
                                'color' => array('rgb' => '000000'),
                                'size' => 13,
                                'name' => 'Calibri'
                        ));
                        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->mergeCells("M1:Q1");
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M1', 'Assessment Mark List');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M2', 'Student Name');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N2', 'Term');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O2', 'Assessment');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('P2', 'Subject');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Q2', 'Assessment Mark');
                        $assessmentmarks = Assessmentmark::model()->findAll();
                        $ass = 3;
                        foreach ($assessmentmarks as $assessmentmark) {
                            $student = Student::model()->findByPk($assessmentmark->studentid);
                            $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;
                            if ($student->batchid === $batchid && $student->courseid === $courseid) {
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M' . $ass, $studentname);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N' . $ass, $assessmentmark->term->term_name);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O' . $ass, $assessmentmark->assessment->assessment_name);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('P' . $ass, $assessmentmark->subject->subject_code . " - " . $assessmentmark->subject->subject_name);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Q' . $ass, $assessmentmark->assessmentmark);
                                $ass++;
                            }
                        }

                        $objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->mergeCells("T1:W1");
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('T1', 'Skill Mark List');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('T2', 'Student Name');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('U2', 'Skill');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('V2', 'Sub Skill');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('W2', 'Mark');

                        $gpaskillsmarks = Gpaskillsmark::model()->findAll();
                        $skll = 3;
                        foreach ($gpaskillsmarks as $gpaskillsmark) {
                            $student = Student::model()->findByPk($gpaskillsmark->studentid);
                            $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;
                            if ($student->batchid === $batchid && $student->courseid === $courseid) {
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('T' . $skll, $studentname);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('U' . $skll, $gpaskillsmark->gpasubskills->gpaskills->gpaskills_name);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('V' . $skll, $gpaskillsmark->gpasubskills->gpasubskills_name);
                                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('W' . $skll, $gpaskillsmark->mark);
                            }
                            $skll++;
                        }


                        // Rename worksheet
                        $objPHPExcel->getActiveSheet()->setTitle($course->course_name . " - " . $batch->batch_name);
                        $i++;
                    }
                } else if ($syllabus->syllabus_name === "CCE") {

                    $i = 0;
                    foreach ($batches as $batch) {
                        $batchid = $batch->batchid;
                        $objPHPExcel->createSheet($i); //Setting index when creating

                        $styleArray = array(
                            'font' => array(
                                'bold' => true,
                                'color' => array('rgb' => '000000'),
                                'size' => 13,
                                'name' => 'Calibri'
                        ));
                        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->mergeCells("A1:G1");

                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Scholastic Mark List');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'Student Name');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'Term');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Assessment');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Exam');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Subject');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Subject Sub');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G2', 'Mark');


                        $setmarklists = Ccemarklist::model()->findAll();
                        $ccem = 3;
                        foreach ($setmarklists as $setmark) {
                            $student = Student::model()->findByPk($setmark->studentid);
                            if (isset($student)) {
                                $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;
                                if ($student->batchid === $batchid && $student->courseid === $courseid) {
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $ccem, $studentname);

                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $ccem, $setmark->ccesetexam->cceterm->ccetermname);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $ccem, $setmark->ccesetexam->cceassessment->cceassessmentname);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $ccem, $setmark->cceexamscheme->examname);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $ccem, $setmark->subject->subject_code . " - " . $setmark->subject->subject_name);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $ccem, $setmark->ccesubjectsub->ccesubjectsubname);
                                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $ccem, $setmark->ccemarklist_mark);
                                    $ccem++;
                                }
                            }
                        }

                        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->mergeCells("J1:N1");
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J1', 'Co-Scholastic Mark List');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J2', 'Student Name');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K2', 'Category');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L2', 'Skill');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M2', 'Indicator');
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N2', 'Grade');
                        $coscholmarklists = Ccecoscholasticmarklist::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batchid));
                        $co = 3;
                        foreach ($coscholmarklists as $coscholmark) {
                            $student = Student::model()->findByPk($coscholmark->studentid);
                            $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;

                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J' . $co, $studentname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K' . $co, $coscholmark->cceskills->ccecategory->ccecategoryname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L' . $co, $coscholmark->cceskills->cceskillsname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M' . $co, $coscholmark->indicatordata);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N' . $co, $coscholmark->grade);
                            $co++;
                        }

                        // Rename worksheet
                        $objPHPExcel->getActiveSheet()->setTitle($course->course_name . " - " . $batch->batch_name);
                        $i++;
                    }
                }


                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = $course->course_name . "_exam_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
//                }
            }

            if ($studentexportdetails === '3') { //! Fee details
                $course = Course::model()->findByPk($courseid); //! $course stores course details
//                if ($course->attendancetype == "0") { //! Check whether the attendenace type is daily attendance. If yes,
                $batches = Batch::model()->findAllByAttributes(array('courseid' => $courseid));
                $i = 0;
                foreach ($batches as $batch) {
                    $batchid = $batch->batchid;
                    $objPHPExcel->createSheet($i); //Setting index when creating
                    $styleArray = array(
                        'font' => array(
                            'bold' => true,
                            'color' => array('rgb' => '000000'),
                            'size' => 13,
                            'name' => 'Calibri'
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->mergeCells("A1:N1");
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Fee Details');

                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'Student Name');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'Fee Category');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Fee Sub Category');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Fee Type');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Amount');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Fine');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G2', 'Discount');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H2', 'Mode of Pay');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I2', 'Paid Date');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J2', 'Remarks');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K2', 'Bank Name');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L2', 'Cheque No.');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M2', 'Cheque Date');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N2', 'Receipt No.');


                    $feepaymentdetails = Feepaymentdetails::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batchid));
                    $fee = 3;
                    foreach ($feepaymentdetails as $feepayment) {
                        $student = Student::model()->findByPk($feepayment->studentid);
                        $studentname = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;

                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $fee, $studentname);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $fee, $feepayment->feessubcategory->feescategory->feescategory_name);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $fee, $feepayment->feessubcategory->feessubcategory_name);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $fee, $feepayment->feessubcategorydates->name . "( " . $feepayment->feessubcategorydates->start_date . " - " . $feepayment->feessubcategorydates->end_date . " )");
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $fee, $feepayment->amount);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $fee, $feepayment->fine);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $fee, $feepayment->discount);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H' . $fee, Feepaymentdetails::model()->modeofpay($feepayment->modeofpay));
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I' . $fee, $feepayment->paiddate);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J' . $fee, $feepayment->remarks);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K' . $fee, $feepayment->bankname);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L' . $fee, $feepayment->chequeno);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M' . $fee, $feepayment->chequedate);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N' . $fee, $feepayment->receiptno);

                        $fee++;
                    }
                    $objPHPExcel->getActiveSheet()->setTitle($course->course_name . " - " . $batch->batch_name);
                    $i++;
                }
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = $course->course_name . "_fee_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
            }
        }
        if ($_POST['exportfor'] === '2') { //! School details like payroll, accounting, student details, transport fee details
            $schoolexportdetails = $_POST['schoolexportdetails'];

            if ($schoolexportdetails === '1') { //! Payroll details
                $designations = Designation::model()->findAll();
                $i = 0;
                foreach ($designations as $designation) {
                    $designationid = $designation->designationid;
                    $objPHPExcel->createSheet($i); //Setting index when creating
                    $styleArray = array(
                        'font' => array(
                            'bold' => true,
                            'color' => array('rgb' => '000000'),
                            'size' => 13,
                            'name' => 'Calibri'
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->mergeCells("A1:F1");
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Payroll Details');

                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'Designation');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'Month');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Pay Head');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Amount');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Addition or Deduction');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Date');


                    $empsalarydetails = Employeesalarydetails::model()->findAll();
                    $emp = 3;
                    foreach ($empsalarydetails as $empsalary) {
                        if ($empsalary->employeesalary->designationid === $designationid) {
                            $employee = Employee::model()->findByPk($empsalary->employeesalary->employeeid);
                            $empname = $employee->employee_code . " - " . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname;
                            if ($empsalary->employeesalary->month === '1') {
                                $month = 'January';
                            }
                            if ($empsalary->employeesalary->month === '2') {
                                $month = 'February';
                            }
                            if ($empsalary->employeesalary->month === '3') {
                                $month = 'March';
                            }
                            if ($empsalary->employeesalary->month === '4') {
                                $month = 'April';
                            }
                            if ($empsalary->employeesalary->month === '5') {
                                $month = 'May';
                            }
                            if ($empsalary->employeesalary->month === '6') {
                                $month = 'June';
                            }
                            if ($empsalary->employeesalary->month === '7') {
                                $month = 'July';
                            }
                            if ($empsalary->employeesalary->month === '8') {
                                $month = 'August';
                            }
                            if ($empsalary->employeesalary->month === '9') {
                                $month = 'September';
                            }
                            if ($empsalary->employeesalary->month === '10') {
                                $month = 'October';
                            }
                            if ($empsalary->employeesalary->month === '11') {
                                $month = 'November';
                            }
                            if ($empsalary->employeesalary->month === '12') {
                                $month = 'December';
                            }

                            if ($empsalary->additionordeduction === '+') {
                                $addded = "Addition";
                            }
                            if ($empsalary->additionordeduction === '-') {
                                $addded = "Deduction";
                            }
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $emp, $empname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $emp, $month);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $emp, $empsalary->payhead);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $emp, $empsalary->amount);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $emp, $addded);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $emp, $empsalary->employeesalary->date);
                            $emp++;
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setTitle($designation->designation_name);
                    $i++;
                }
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = "payroll_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
            }

            if ($schoolexportdetails === '2') { //! Accounting details
                $vouchermasters = Vouchermaster::model()->findAll();
                $i = 0;
                foreach ($vouchermasters as $vouchermaster) {
                    $vouchermasterid = $vouchermaster->vouchermasterid;
                    $objPHPExcel->createSheet($i); //Setting index when creating
                    $styleArray = array(
                        'font' => array(
                            'bold' => true,
                            'color' => array('rgb' => '000000'),
                            'size' => 13,
                            'name' => 'Calibri'
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->mergeCells("A1:H1");
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Accounting Details');

                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'Voucher Head');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'Transaction Date');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Account Name');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Employee');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Credit');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Debit');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G2', 'Voucher Number');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H2', 'Description');


                    $vouchers = Voucher::model()->findAll();
                    $vo = 3;
                    foreach ($vouchers as $voucher) {
                        if ($voucher->vouchermasterid === $vouchermasterid) {
                            $employee = Employee::model()->findByPk($voucher->usermasterid);
                            $empname = $employee->employee_code . " - " . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname;

                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $vo, $voucher->voucherHead->voucherhead);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $vo, $voucher->dateMaster->transactiondate);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $vo, $voucher->accountGroup->accountname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $vo, $empname);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $vo, $voucher->credit);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $vo, $voucher->debit);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $vo, $voucher->vouchernumber);
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H' . $vo, $voucher->description);
                            $vo++;
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setTitle($vouchermaster->vouchermaster);
                    $i++;
                }
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = "accounting_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
            }

            if ($schoolexportdetails === '3') { //! Transport fee details
                $i = 0;
                $objPHPExcel->createSheet($i); //Setting index when creating
                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000'),
                        'size' => 13,
                        'name' => 'Calibri'
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->mergeCells("A1:N1");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Transport Fee Details');

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'User Type');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'User');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Route');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Destination');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Fee Type');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Amount');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G2', 'Fine');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H2', 'Discount');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I2', 'Mode of Pay');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J2', 'Paid Date');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K2', 'Remarks');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L2', 'Bank Name');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M2', 'Cheque No.');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N2', 'Cheque Date');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O2', 'Receipt No.');


                $transfeepaymentdetails = Transportfeecollection::model()->findAll();
                $trans = 3;
                foreach ($transfeepaymentdetails as $transfeepayment) {
                    if ($transfeepayment->usertypeid === '1') {
                        $student = Student::model()->findByPk($transfeepayment->userid);
                        $user = $student->student_admissionno . " - " . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname;
                        $usertype = "Student";
                    }
                    if ($transfeepayment->usertypeid === '2') {
                        $employee = Employee::model()->findByPk($transfeepayment->userid);
                        $user = $employee->employee_code . " - " . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname;
                        $usertype = "Employee";
                    }

                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $trans, $usertype);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $trans, $user);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $trans, $transfeepayment->routemaster->routemaster_code);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $trans, $transfeepayment->routedetail->routedetails_stopposition);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $trans, $transfeepayment->transportfeedates->name . "( " . $transfeepayment->transportfeedates->start_date . " - " . $transfeepayment->transportfeedates->end_date . " )");
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $trans, $transfeepayment->amount);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $trans, $transfeepayment->fine);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H' . $trans, $transfeepayment->discount);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I' . $trans, Feepaymentdetails::model()->modeofpay($transfeepayment->modeofpay));
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J' . $trans, $transfeepayment->paiddate);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K' . $trans, $transfeepayment->remarks);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L' . $trans, $transfeepayment->bankname);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M' . $trans, $transfeepayment->chequeno);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N' . $trans, $transfeepayment->chequedate);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O' . $trans, $transfeepayment->receiptno);

                    $trans++;
                }
                $objPHPExcel->getActiveSheet()->setTitle("Transport fee");
//                    $i++;
//                }
                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = "transportfee_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
            }

            if ($schoolexportdetails === '4') { //! Student details
                $i = 0;
                $objPHPExcel->createSheet($i); //Setting index when creating
                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000'),
                        'size' => 13,
                        'name' => 'Calibri'
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->mergeCells("A1:AR1");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A1', 'Student Details');

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A2', 'Admission Number');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B2', 'Student Name');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C2', 'Admission Date');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D2', 'Date of Birth');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E2', 'Course');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F2', 'Batch');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G2', 'Gender');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H2', 'Blood Group');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I2', 'Birth Place');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J2', 'Nationality');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K2', 'Mothertoung');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L2', 'Category');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M2', 'Religion');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N2', 'Permanant Address');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O2', 'Present Address');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('P2', 'City');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Q2', 'State');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('R2', 'Country');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('S2', 'Pin Code');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('T2', 'Phone');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('U2', 'Mobile');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('V2', 'Email');

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('W2', 'Guardian Name');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('X2', 'Guardian Phone');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Y2', 'Guardian Address');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Z2', 'City');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AA2', 'State');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AB2', 'Country');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AC2', 'Guardian Email');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AD2', 'Guardian Mobile');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AE2', 'Relation');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AF2', 'Education');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AG2', 'Occupation');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AH2', 'Income');

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AI2', "Father's Name");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AJ2', "Father's Mobile");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AK2', "Father's Job");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AL2', "Mother's Name");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AM2', "Mother's Mobile");
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AN2', "Mother's Job");

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AO2', 'Previous School Name');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AP2', 'School Address');
                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AQ2', 'Qualification');

                $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AR2', 'Status');

                $students = Student::model()->findAll();
                $stud = 3;
                foreach ($students as $student) {
                    if ($student->student_bloodgroup === '1') {
                        $bldgrp = 'A+';
                    }
                    if ($student->student_bloodgroup === '2') {
                        $bldgrp = 'A-';
                    }
                    if ($student->student_bloodgroup === '3') {
                        $bldgrp = 'B+';
                    }
                    if ($student->student_bloodgroup === '4') {
                        $bldgrp = 'B-';
                    }
                    if ($student->student_bloodgroup === '5') {
                        $bldgrp = 'O+';
                    }
                    if ($student->student_bloodgroup === '6') {
                        $bldgrp = 'O-';
                    }
                    if ($student->student_bloodgroup === '7') {
                        $bldgrp = 'AB+';
                    }
                    if ($student->student_bloodgroup === '8') {
                        $bldgrp = 'AB-';
                    }
                    $course = Course::model()->findByPk($student->courseid);
                    $batch = Batch::model()->findByPk($student->batchid);
                    $category = Studentcategory::model()->findByPk($student->studentcategoryid);

                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('A' . $stud, $student->student_admissionno);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('B' . $stud, $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('C' . $stud, $student->student_admissiondate);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('D' . $stud, $student->student_dob);
                    if (isset($course)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('E' . $stud, $course->course_name);
                    }
                    if (isset($batch)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('F' . $stud, $batch->batch_name);
                    }
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('G' . $stud, $student->student_gender == 1 ? 'Male' : 'Female');
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('H' . $stud, $bldgrp);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('I' . $stud, $student->student_birthplace);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('J' . $stud, $student->student_nationality);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('K' . $stud, $student->student_mothertoung);
                    if (isset($category)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('L' . $stud, $category->studentcategory_name);
                    }
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('M' . $stud, $student->student_religion);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('N' . $stud, $student->student_address1);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('O' . $stud, $student->student_address2);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('P' . $stud, $student->student_city);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Q' . $stud, $student->student_state);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('R' . $stud, $student->student_country);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('S' . $stud, $student->student_pincode);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('T' . $stud, $student->student_phone);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('U' . $stud, $student->student_mobile);
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('V' . $stud, $student->student_email);
                    $guardian = Guardian::model()->findByPk($student->guardianid);
                    if (isset($guardian)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('W' . $stud, $guardian->guardian_name);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('X' . $stud, $guardian->guardian_phone);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Y' . $stud, $guardian->guardian_address);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('Z' . $stud, $guardian->guardian_city);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AA' . $stud, $guardian->guardian_state);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AB' . $stud, $guardian->guardian_country);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AC' . $stud, $guardian->guardian_email);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AD' . $stud, $guardian->guardian_mobile);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AE' . $stud, $guardian->guardian_relation);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AF' . $stud, $guardian->guardian_education);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AG' . $stud, $guardian->guardian_occupation);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AH' . $stud, $guardian->guardian_income);
                    }
                    $parentdetails = Parentdetails::model()->findByAttributes(array('studentid' => $student->studentid));
                    if (isset($parentdetails)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AI' . $stud, $parentdetails->father_name);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AJ' . $stud, $parentdetails->father_mobile);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AK' . $stud, $parentdetails->father_job);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AL' . $stud, $parentdetails->mother_name);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AM' . $stud, $parentdetails->mother_mobile);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AN' . $stud, $parentdetails->mother_job);
                    }
                    $previous = Previousqualification::model()->findByPk($student->previousqualificationid);
                    if (isset($previous)) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AO' . $stud, $previous->previousqualification_schoolname);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AP' . $stud, $previous->previousqualification_address);
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AQ' . $stud, $previous->qualification);
                    }
                    if ($student->status === '0') {
                        $status = 'Existing';
                    } else if ($student->status === '1') {
                        $status = 'Existing';
                    } else if ($student->status === '2') {
                        $status = 'Alumni';
                    } else if ($student->status === '3') {
                        $status = 'Withdrawal';
                    } else {
                        $status = 'Existing';
                    }
                    $objPHPExcel->setActiveSheetIndex($i)->setCellValue('AR' . $stud, $status);
                    $stud++;
                }
                $objPHPExcel->getActiveSheet()->setTitle("Students");

                $objPHPExcel->setActiveSheetIndex(0);
                $academic = Academic::model()->find();
                $filename = "studentdetails_" . $academic->academic_startyear . "-" . $academic->academic_endyear . ".xls";

// Redirect output to a clientâ€™s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=' . $filename);
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objWriter->save(str_replace(__FILE__, Yii::app()->basePath . '/../excelfiles/' . $filename, __FILE__));

                Yii::app()->end();
            }
        }
    }

    public function actionDrawfeegraph() {
        $courselist = array();
        $collected = array();
        $total = array();
        $remaining = array();

        $collected_rs = 0;
        $total_rs = 0;
        // $courseid = $_POST['Feescollection']['courseid'];
        $courses = Course::model()->findAll();
        //array_push($courselist, $courses);
        foreach ($courses as $course) {
            $amount = 0;
            $collected_rs = 0;
            $courseid = $course->courseid;
            array_push($courselist, $course->course_name);
            $batchs = Batch::model()->findAllByAttributes(array('courseid' => $courseid));
            foreach ($batchs as $batch) {
                $students = Student::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batch->batchid));
                foreach ($students as $student) {
                    $count = count($students);
                    $feesallocations = Feesallocation::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batch->batchid));
                    foreach ($feesallocations as $feesallocation) {
                        $feesubs = Feessubcategory::model()->findAllByAttributes(array('feessubcategoryid' => $feesallocation->feesallocationid));

                        foreach ($feesubs as $feesub) {

                            if ($feesub->excemption_deduction === '1') { // 1=>None, 2=>excemption, 3=>Deduction
                                $amount = $amount + $feesub->feessubcategory_amount;
                            }
                            if ($feesub->excemption_deduction === '2') {
                                if ($feesub->category_gender === '0') {
                                    $amount = $amount + ($feesub->feessubcategory_amount - $feesub->feessubcategory_amount);
                                } elseif ($feesub->category_gender === '1') {//1=>category, 2=>gender
                                    if ($feesub->category === $student->studentcategoryid) {
                                        $amount = $amount + ($feesub->feessubcategory_amount - $feesub->feessubcategory_amount);
                                    } else {
                                        $amount = $amount + ($feesub->feessubcategory_amount);
                                    }
                                } elseif ($feesub->category_gender === '2') {
                                    if ($feesub->gender === $student->student_gender) {
                                        $amount = $amount + ($feesub->feessubcategory_amount - $feesub->feessubcategory_amount);
                                    } else {
                                        $amount = $amount + ($feesub->feessubcategory_amount);
                                    }
                                }
                            }
                            if ($feesub->excemption_deduction === '3') {

                                if ($feesub->category_gender === '0') {
                                    $amount = $amount + ($feesub->feessubcategory_amount - ($feesub->feessubcategory_amount * ($feesub->deductionamountpercentage / 100)));
                                } elseif ($feesub->category_gender === '1') {//1=>category, 2=>gender
                                    if ($feesub->category === $stud->studentcategoryid) {
                                        $amount = $amount + ($feesub->feessubcategory_amount - ($feesub->feessubcategory_amount * ($feesub->deductionamountpercentage / 100)));
                                    } else {
                                        $amount = $amount + ($feesub->feessubcategory_amount);
                                    }
                                } elseif ($feesub->category_gender === '2') {
                                    if ($feesub->gender === $stud->student_gender) {
                                        $amount = $amount + ($feesub->feessubcategory_amount - ($feesub->feessubcategory_amount * ($feesub->deductionamountpercentage / 100)));
                                    } else {
                                        $amount = $amount + ($feesub->feessubcategory_amount);
                                    }
                                }
                            }
                        }
                    }
                }
                $feepaymentdetails = Feepaymentdetails::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batch->batchid));
                foreach ($feepaymentdetails as $feepaymentdetail) {
                    $collected_rs = $collected_rs + ($feepaymentdetail->amount);
                }
            }
            $rem = $amount - $collected_rs;
            array_push($total, $amount);
            array_push($collected, $collected_rs);
            array_push($remaining, $rem);
        }
        $this->renderPartial('_feegraph', array('total' => $total, 'collected' => $collected, 'remaining' => $remaining, 'courselist' => $courselist), false, true);
    }

    public function actionSavetodo() {
        $model_todo = new Todo;

        $model_todo->todo_subject = "";
        $model_todo->todo_content = $_POST['todocontent'];
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $model_todo->financialyearid = $financialyear->financialyearid;
        $model_todo->companyid = Yii::app()->user->companyid;
        $model_todo->usertypeid = Yii::app()->user->usertypeid;
        $model_todo->userid = Yii::app()->user->userid;

        $date = $_POST['todo_date'];
        $date1 = date_create($date);
        $model_todo->todo_date = date_format($date1, 'Y-m-d');

        $model_todo->save(false);
    }

    public function actionUpdatetodo() {

        $model_todo = Todo::model()->findByPk($_GET['id']);

        $model_todo->todo_subject = "";
        $model_todo->todo_content = $_POST['todocontent'];
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $model_todo->financialyearid = $financialyear->financialyearid;
        $model_todo->companyid = Yii::app()->user->companyid;
        $model_todo->usertypeid = Yii::app()->user->usertypeid;
        $model_todo->userid = Yii::app()->user->userid;

        $date = $_POST['todo_date'];
        $date1 = date_create($date);
        $model_todo->todo_date = date_format($date1, 'Y-m-d');

        $model_todo->save();
        $this->redirect(array('index'));
    }

    public function actionDeletetodo() {
        $todo = Todo::model()->deleteByPk($_GET['id']);
        $this->redirect(array('index'));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionUsers() {

        $model = new Institution;
        $this->render('users', array(
            'model' => $model,
        ));
    }

    public function actionFetchbatch() {

        $data = Batch::model()->findAll('courseid=:courseid', array(':courseid' => (int) $_POST['Institution']['courseid']));

        $data = CHtml::listData($data, 'batchid', 'batch_name');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data as $value => $eachbatch) {

            echo CHtml::tag('option', array('value' => $value), CHtml::encode($eachbatch), true);
        }
    }

    public function actionFetchbatchforgua() {

        $data = Batch::model()->findAll('courseid=:courseid', array(':courseid' => (int) $_POST['Institution']['courseid1']));

        $data = CHtml::listData($data, 'batchid', 'batch_name');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data as $value => $eachbatch) {

            echo CHtml::tag('option', array('value' => $value), CHtml::encode($eachbatch), true);
        }
    }

    public function actionUserslist() {
        $user = $_POST['user'];

        if ($user === '1') {
            $courseid = $_POST['courseid'];
            $batchid = $_POST['batchid'];
            $students = Student::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batchid));

            foreach ($students as $student) {
                $usersstudent = Users::model()->findByAttributes(array('usertypeid' => '1', 'userid' => $student->studentid));
                $guardian = Guardian::model()->findByPk($student->guardianid);
                $userguardian = Users::model()->findByAttributes(array('usertypeid' => '3', 'userid' => $student->guardianid));

                echo '<tr>'
                . '<td style="display:none">' . $student->studentid . '</td>'
                . '<td>' . $student->student_admissionno . '</td>'
                . '<td>' . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname . '</td>'
                . '<td>' . $usersstudent->username . '</td>'
                . '<td><input type="radio" class="studentcheckbox" name="studentcheckbox">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#newMail" data-toggle="modal">Reset</a></td>'
                . '<tr>';

//                print_r($users);exit;
            }
        } else if ($user === '2') {
            $departmentid = $_POST['departmentid'];
            $employees = Employee::model()->findAllByAttributes(array('departmentid' => $departmentid));

            foreach ($employees as $employee) {
                $useremployees = Users::model()->findAllByAttributes(array('userid' => $employee->employeeid));
                foreach ($useremployees as $useremployee) {
//                    print_r($useremployee);exit;
                    if ($useremployee->usertypeid === '1') {
                        
                    } else if ($useremployee->usertypeid === '3') {
                        
                    } else {
                        echo '<tr>'
                        . '<td style="display:none">' . $employee->employeeid . '</td>'
                        . '<td>' . $employee->employee_code . '</td>'
                        . '<td>' . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname . '</td>'
                        . '<td>' . $useremployee->username . '</td>'
                        . '<td><input type="radio" class="employeecheckbox" name="employeecheckbox">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#newMail" data-toggle="modal">Reset</a></td>'
                        . '</tr>';
                    }
                }
            }
        } else if ($user === '3') {
            $courseid = $_POST['courseid'];
            $batchid = $_POST['batchid'];
            $students = Student::model()->findAllByAttributes(array('courseid' => $courseid, 'batchid' => $batchid));

            foreach ($students as $student) {
                $usersstudent = Users::model()->findByAttributes(array('usertypeid' => '1', 'userid' => $student->studentid));
                $guardian = Guardian::model()->findByPk($student->guardianid);
                $userguardian = Users::model()->findByAttributes(array('usertypeid' => '3', 'userid' => $student->guardianid));

                echo '<tr>'
                . '<td style="display:none">' . $student->guardianid . '</td>'
                . '<td>' . $student->student_admissionno . '</td>'
                . '<td>' . $student->student_firstname . " " . $student->student_middlename . " " . $student->student_lastname . '</td>'
                . '<td>' . $guardian->guardian_name . '</td>'
                . '<td>' . $userguardian->username . '</td>'
                . '<td><input type="radio" class="guardianradio" name="guardiancheckbox">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#newMail1" data-toggle="modal">Reset</a></td>'
                . '<tr>';
            }
        }
    }

    public function actionResetpassword() {

        $user = $_POST['user'];

        if ($user === '1') {  //student
            $userid = $_POST['studentid'];
            $username = $_POST['username'];
            $users = Users::model()->findByAttributes(array('username' => $username, 'usertypeid' => '1', 'userid' => $userid));
            $usersid = $users->id;

            $rtn = User::model()->userupdate($username, $usersid);
        } else if ($user === '2') { //employees
            $userid = $_POST['employeeid'];
            $username = $_POST['username'];

            $users = Users::model()->findByAttributes(array('username' => $username, 'userid' => $userid));
            $usersid = $users->id;

            $rtn = User::model()->userupdate($username, $usersid);
        }
    }

    public function actionCheckmail() {

        $model = Email::model()->findAllByAttributes(array('to_userid' => Yii::app()->user->id, 'email_status' => '1'));
        echo count($model);
    }

    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'

        $usertype = Yii::app()->user->usertypeid;

        if ($usertype === '0') {//0
//            $this->render('home'); //dashboard super admin
            $this->render('index');
        } else {
            $this->render('employee'); //dashboard employee
        }
    }

    public function actionSuperadmin() {
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionEmployeeimport() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $uploadedFile = CUploadedFile::getInstance($model, 'filea');
            if ($uploadedFile == "") {
                Yii::app()->user->setFlash('error', 'Please select a file.');
            } else {
                $allowed = array('xlsx', 'xls');
                $filename = CUploadedFile::getInstance($model, 'filea');
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    throw new CHttpException(404, 'File extension error. The allowed extension is xlsx.');
                    exit(0);
                } else {

                    $ext = end((explode(".", $uploadedFile)));
                    $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                    $date = new DateTime();
                    $date->setTimezone($timezone);
                    $date = $date->format('dmYhis');
                    $fileName = "{$date}.{$ext}";
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                    //reading portion : here each column is read row and column wise; please check the sample
                    //import file to get the column format. The heading row can be kept. The heading is ignored
                    //while reading the excel or csv file.

                    $sheet_array = Yii::app()->yexcel->readActiveSheet(Yii::app()->basePath . '/../banner/' . $fileName);
                    $count = 0;
                    foreach ($sheet_array as $row) {
                        $count = $count + 1;
                    }
                    for ($x = 2; $x <= $count; $x++) {

                        try {
                            if ($sheet_array[$x]['A'] == "" && $sheet_array[$x]['B'] == "" && $sheet_array[$x]['C'] == "" && $sheet_array[$x]['D'] == "" && $sheet_array[$x]['E'] == "" && $sheet_array[$x]['F'] == "" && $sheet_array[$x]['G'] == "" && $sheet_array[$x]['H'] == "" && $sheet_array[$x]['I'] == "" && $sheet_array[$x]['J'] == "" && $sheet_array[$x]['K'] == "" && $sheet_array[$x]['L'] == "" && $sheet_array[$x]['M'] == "" && $sheet_array[$x]['N'] == "" && $sheet_array[$x]['O'] == "" && $sheet_array[$x]['P'] == "" && $sheet_array[$x]['Q'] == "" && $sheet_array[$x]['R'] == "" && $sheet_array[$x]['S'] == "" && $sheet_array[$x]['T'] == "" && $sheet_array[$x]['U'] == "" && $sheet_array[$x]['V'] == "") {
                                $this->redirect(array('/core/employeedetails/admin'), array('message' => 'Successfuly Updated!'));
                            }
                            $employee = new Employee;
                            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                            $emp_code = Employee::model()->findByAttributes(array('employee_code' => $sheet_array[$x]['A'],'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));

                            if ($sheet_array[$x]['A'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field employee code validation error');
                                exit(0);
                            } elseif ($emp_code != "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'Employee code already exist.');
                                exit(0);
                            } else {
//                                if ($financialyear->isautogeneration === '1') {
//                                    $schoolcode = $financialyear->company_code;
//                                    $employee->employee_code = "e" . $schoolcode . $sheet_array[$x]['A'];
//                                } else {
                                    $employee->employee_code = "e" . $sheet_array[$x]['A'];
//                                }
                            }
                            if ($sheet_array[$x]['B'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field employee name validation error');
                                exit(0);
                            } else {
                                $employee->employee_firstname = $sheet_array[$x]['B'];
                            }
                            $employee->employee_middlename = $sheet_array[$x]['C'];
                            $employee->employee_lastname = $sheet_array[$x]['D'];
                            if ($sheet_array[$x]['E'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field date of birth validation error');
                                exit(0);
                            } else {
//                                $date1 = date_create($sheet_array[$x]['E']);
//                                $date = date_format($date1, 'Y-m-d');
                                $employee->employee_dob = $sheet_array[$x]['E'];
                            }
                            if ($sheet_array[$x]['F'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field gender validation error');
                                exit(0);
                            } else {
                                $gender = (strcasecmp($sheet_array[$x]['F'], "female")) ? 1 : 2;
                                $employee->employee_gender = $gender;
                            }
                            $department = Department::model()->findByAttributes(array('department_name' => $sheet_array[$x]['G'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
                            if ($department == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field department validation error');
                                exit(0);
                            } else {
                                $employee->departmentid = $department->departmentid;
                            }
                            $division = Division::model()->findByAttributes(array('division_name' => $sheet_array[$x]['W'], 'departmentid' => $department->departmentid, 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
                            if ($division == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field division validation error');
                                exit(0);
                            } else {
                                $employee->divisionid = $division->divisionid;
                            }
                            $designation = Designation::model()->findByAttributes(array('designation_name' => $sheet_array[$x]['I'], 'departmentid' => $department->departmentid, 'divisionid' => $division->divisionid, 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
                            if ($designation == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field designation validation error');
                                exit(0);
                            } else {
                                $employee->designationid = $designation->designationid;
                            }
                            if ($sheet_array[$x]['J'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field joining date validation error');
                                exit(0);
                            } else {
//                                $date1 = date_create($sheet_array[$x]['J']);
//                                $date = date_format($date1, 'Y-m-d');
                                $employee->employee_joiningdate = $sheet_array[$x]['J'];
                            }
//                            $employee->companyid = $sheet_array[$x]['H'];
                            $employee->financialyearid = $financialyear->financialyearid;
                            $employee->companyid = Yii::app()->user->companyid;
//                            $employee->save(false);
                            if ($sheet_array[$x]['K'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field qualification validation error');
                                exit(0);
                            } else {
                                $employee->employee_qualification = $sheet_array[$x]['K'];
                            }
                            if ($sheet_array[$x]['L'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field experience validation error');
                                exit(0);
                            } else {
                                $employee->employee_totalexperiance = $sheet_array[$x]['L'];
                            }
                            if ($sheet_array[$x]['M'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field present address validation error');
                                exit(0);
                            } else {
                                $employee->employee_address1 = $sheet_array[$x]['M'];
                            }
                            $employee->employee_address2 = $sheet_array[$x]['N'];
                            if ($sheet_array[$x]['O'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field city validation error');
                                exit(0);
                            } else {
                                $employee->employee_city = $sheet_array[$x]['O'];
                            }
                            if ($sheet_array[$x]['P'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field state validation error');
                                exit(0);
                            } else {
                                $employee->employee_state = $sheet_array[$x]['P'];
                            }
                            if ($sheet_array[$x]['Q'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field country validation error');
                                exit(0);
                            } else {
                                $employee->employee_country = $sheet_array[$x]['Q'];
                            }

                            if ($sheet_array[$x]['R'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field pincode validation error');
                                exit(0);
                            } else {
                                $employee->employee_pincode = $sheet_array[$x]['R'];
                            }
//                    if ($sheet_array[$x]['S'] == "") {
//                        throw new CHttpException(404, 'Row number :' . $x . 'The field phone validation error');
//                        exit(0);
//                    } else {
                            $employee->employee_phone = $sheet_array[$x]['S'];
//                    }
                            if ($sheet_array[$x]['T'] == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field mobile validation error');
                                exit(0);
                            } else {
                                $employee->employee_mobile = $sheet_array[$x]['T'];
                            }

                            $employee_mail = Employee::model()->findByAttributes(array('employee_email' => $sheet_array[$x]['U']));
                            if ($sheet_array[$x]['U'] == "" || (!filter_var($sheet_array[$x]['U'], FILTER_VALIDATE_EMAIL))) {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field email validation error');
                                exit(0);
                            } else if ($employee_mail != "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'Email already exist.');
                                exit(0);
                            } else {
                                $employee->employee_email = $sheet_array[$x]['U'];
                            }
                            $usertype = Usertype::model()->findByAttributes(array('usertype_name' => $sheet_array[$x]['V'],'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                            if ($usertype == "") {
                                throw new CHttpException(404, 'Row number :' . $x . 'The field usertype validation error');
                                exit(0);
                            } else {
                                $usertypeid = $usertype->usertypeid;
                                $employee->usertypeid = $usertype->usertypeid;
                            }
                            $employee->employee_status = 1;
                            $employee->save(false);

                            // $usertype = $usertype->usertypeid;
                            $userid = $employee->employeeid;
                            $companyid = Yii::app()->user->companyid;
                            $email = $employee->employee_email;
                            $username = $companyid . $employee->employee_code;
                            $rtn = User::model()->usersignup($username, $usertypeid, $userid, $companyid, $email); //format $username, $usertype, $userid
                        } catch (CDbException $e) {
                            throw new CHttpException(404, 'Something went wrong while uploading your excel file.');
                        }
                    }
//                $this->render('contact_emp', array('model' => $model, 'message' => 'Successfuly Updated!'));
                    if ($x == 2) {
                        $this->render('contact', array('model' => $model, 'message' => 'The file you uploaded is empty.!'));
                    } else {
                        $this->redirect(array('/core/employee/admin'), array('message' => 'Successfuly Updated!'));
                    }
                }
            }
        }

        $this->render('contact_emp', array('model' => $model, 'message' => ''));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
