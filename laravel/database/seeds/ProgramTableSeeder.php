<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Program;


/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:25 AM
 */
class ProgramTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Create an array of programs
        $programs = array(
            array('CE.NONMATRIC', 'CONTINUING EDUCATION NONMATRIC', 1),
            array('JCA.AA.INS', 'INDIVIDUAL STUDIES', 2),
            array('RSC.BA.AMS', 'AMERICAN STUDIES', 3),
            array('RSC.BA.AMS.ENG', 'DOUBLE MJR: AMERICAN STUDIES & ENGLISH', 4),
            array('RSC.BA.BIO', 'BIOLOGY (BA DEGREE)', 5),
            array('RSC.BA.BIO.4OTH', 'BIOLOGY', 5),
            array('RSC.BA.BIO.4PTH', 'BIOLOGY', 5),
            array('RSC.BA.BIO.ENVS', 'BIOLOGY WITH ENVIRONMENTAL SCIENCE CONCENTRATION', 5),
            array('RSC.BA.BIO.OTH', 'BIOLOGY LEADING TO THE MS IN OTH', 5),
            array('RSC.BA.BIO.PTH', 'BIOLOGY LEADING TO PTH', 5),
            array('RSC.BA.CAT.ART', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN VISUAL ART', 6),
            array('RSC.BA.CAT.ART.4OTH', 'CREATIVE ARTS THERAPY WITH ART CONCENTRATION', 6),
            array('RSC.BA.CAT.ART.CHL', 'CREATIVE ARTS THERAPY: ART - CHILD LIFE SPECIALIST', 6),
            array('RSC.BA.CAT.ART.OTH', 'CREATIVE ARTS THERAPY - ART LEADING TO OTH', 6),
            array('RSC.BA.CAT.DAN', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN DANCE', 6),
            array('RSC.BA.CAT.DAN.4OTH', 'CREATIVE ARTS THERAPY WITH DANCE CONCENTRATION', 6),
            array('RSC.BA.CAT.DAN.CHL', 'CREATIVE ARTS THERAPY: DANCE - CHILD LIFE SPECIALIST', 6),
            array('RSC.BA.CAT.DAN.OTH', 'CREATIVE ARTS THERAPY - DANCE LEADING TO OTH', 6),
            array('RSC.BA.CAT.MUS', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN MUSIC', 6),
            array('RSC.BA.CAT.MUS.4OTH', 'CREATIVE ARTS THERAPY WITH MUSIC CONCENTRATION', 6),
            array('RSC.BA.CAT.MUS.CHL', 'CREATIVE ARTS THERAPY: MUSIC - CHILD LIFE SPECIALIST', 6),
            array('RSC.BA.CAT.MUS.OTH', 'CREATIVE ARTS THERAPY - MUSIC LEADING TO OTH', 6),
            array('RSC.BA.CAT.THR', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN THEATRE', 6),
            array('RSC.BA.CAT.THR.4OTH', 'CREATIVE ARTS THERAPY WITH THEATRE CONCENTRATION', 6),
            array('RSC.BA.CAT.THR.CHL', 'CREATIVE ARTS THERAPY: THEATRE - CHILD LIFE SPECIALIST', 6),
            array('RSC.BA.CAT.THR.OTH', 'CREATIVE ARTS THERAPY - THEATRE LEADING TO OTH', 6),
            array('RSC.BA.CRM', 'CRIMINAL JUSTICE', 7),
            array('RSC.BA.CRM.SOC', 'DOUBLE MAJOR: CRIMINAL JUSTICE & SOCIOLOGY', 8),
            array('RSC.BA.ENG', 'ENGLISH', 9),
            array('RSC.BA.ENG.CRM', 'DOUBLE MAJOR: ENGLISH & CRIMINAL JUSTICE', 9),
            array('RSC.BA.ENG.OTH', 'ENG LEADING TO MS IN OTH', 9),
            array('RSC.BA.ENG.PSY', 'DOUBLE MAJOR: ENGLISH AND PSYCHOLOGY', 10),
            array('RSC.BA.ENG.PTH', 'ENGLISH LEADING TO PTH', 9),
            array('RSC.BA.ENG.THR', 'DOUBLE MAJOR: ENGLISH AND THEATRE', 9),
            array('RSC.BA.ENVIR.STU', 'ENVIRONMENTAL STUDIES', 11),
            array('RSC.BA.HIS', 'HISTORY', 12),
            array('RSC.BA.HIS.AMS', 'HISTORY: AMERICAN STUDIES PATHWAY', 13),
            array('RSC.BA.HIS.IGS', 'HISTORY: INTERNATIONAL GLOBALIZATION PATHWAY', 13),
            array('RSC.BA.HIS.OTH', 'HISTORY LEADING TO MS IN OTH', 12),
            array('RSC.BA.HIS.PTH', 'HISTORY LEADING TO PTH', 12),
            array('RSC.BA.HIS.PUH', 'HISTORY: PUBLIC HISTORY PATHWAY', 13),
            array('RSC.BA.INT.GLO', 'INTERNATIONAL & GLOBALIZATION STUDIES', 14),
            array('RSC.BA.INTER.DAN.THY', 'INTER MJR: DANCE & THERAPY', 11),
            array('RSC.BA.INTER.PER.HMN', 'INTER MJR: PERSPECTIVES IN HUMANITIES', 11),
            array('RSC.BA.INTER.SPA.CUL', 'INTER MJR: SPANISH LANGUAGE & CULTURE', 11),
            array('RSC.BA.INTER.THA.OTH', 'INTER MJR: THERAPEUTIC STUDIES & ART LEADING TO OTH', 11),
            array('RSC.BA.MAT', 'MATHEMATICS', 15),
            array('RSC.BA.MAT.4PTH', 'MATHEMATICS', 15),
            array('RSC.BA.MAT.EG', 'MATHEMATICS (FOR ENGINEERING OPTION AT RPI)', 15),
            array('RSC.BA.MAT.MSMAT', 'MATHEMATICS', 15),
            array('RSC.BA.PACE', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT', 16),
            array('RSC.BA.PACE.CFP', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT: CHILD/FAM POL', 17),
            array('RSC.BA.PACE.CRJ', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT: CRIM JUST POL', 17),
            array('RSC.BA.PACE.EFP.IGS', 'DOUBLE MJR: PACE W/ECO & FIN POLICY & INTERNAT\'\'L GLOBAL STU', 17),
            array('RSC.BA.PACE.PBH', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMNT: PUBLIC HEALTH', 17),
            array('RSC.BA.POL', 'POLITICAL SCIENCE', 16),
            array('RSC.BA.POL.OTH', 'POLITICAL SCIENCE LEADING TO MS IN OTH', 16),
            array('RSC.BA.PSY', 'PSYCHOLOGY', 18),
            array('RSC.BA.PSY.4OTH', 'PSYCHOLOGY', 18),
            array('RSC.BA.PSY.4PTH', 'PSYCHOLOGY', 18),
            array('RSC.BA.PSY.OTH', 'PSYCHOLOGY LEADING TO MS IN OTH', 18),
            array('RSC.BA.PSY.PTH', 'PSYCHOLOGY LEADING TO PTH', 18),
            array('RSC.BA.SOC', 'SOCIOLOGY', 19),
            array('RSC.BA.SOC.4PTH', 'SOCIOLOGY', 19),
            array('RSC.BA.SOC.ADV', 'SOCIOLOGY W/SOCIAL & HEALTH ADVOCACY CONCENTRATION', 19),
            array('RSC.BA.SOC.CRIM', 'SOCIOLOGY WITH A CONCENTRATION IN CRIME AND SOCIETY', 19),
            array('RSC.BA.SOC.CRJ', 'SOCIOLOGY WITH CRIME & JUSTICE', 19),
            array('RSC.BA.SOC.OTH', 'SOCIOLOGY LEADING TO MS IN OTH', 19),
            array('RSC.BA.SOC.PBH', 'SOCIOLOGY WITH PUBLIC HEALTH', 19),
            array('RSC.BA.SOC.PSY', 'DOUBLE MAJOR: SOCIOLOGY & PSYCHOLOGY', 19),
            array('RSC.BA.SOC.PTH', 'SOCIOLOGY LEADING TO PTH', 19),
            array('RSC.BA.THR', 'THEATRE', 20),
            array('RSC.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('RSC.BBA.BUS.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
            array('RSC.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('RSC.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('RSC.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('RSC.BBA.BUS.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
            array('RSC.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('RSC.BFA.ART', 'BFA FINE ARTS', 23),
            array('RSC.BFA.GMD', 'BFA GRAPHIC & MEDIA DESIGN', 24),
            array('RSC.BFA.IND', 'BFA IN INTERIOR DESIGN', 25),
            array('RSC.BFA.PHG', 'BFA PHOTOGRAPHY', 26),
            array('RSC.BS.ACC', 'ACCOUNTING', 21),
            array('RSC.BS.ACC.MSMBA', 'ACCOUNTING', 27),
            array('RSC.BS.AEX', 'ACADEMIC EXPLORATION', 28),
            array('RSC.BS.APP.BIO', 'APPLIED BIOLOGY', 5),
            array('RSC.BS.APP.BIO.4OTH', 'APPLIED BIOLOGY', 5),
            array('RSC.BS.APP.BIO.4PTY', 'APPLIED BIOLOGY', 5),
            array('RSC.BS.APP.BIO.ENV', 'APPLIED BIOLOGY: ENVIRONMENTAL SCIENCE', 5),
            array('RSC.BS.APP.BIO.FBI', 'APPLIED BIOLOGY (BIOLOGY/FORENSIC BIOLOGY)', 5),
            array('RSC.BS.APP.BIO.ILL', 'APPLIED BIOLOGY: ILLUSTRATION', 5),
            array('RSC.BS.APP.BIO.L&S', 'APPLIED BIOLOGY: LAW & SOCIETY', 5),
            array('RSC.BS.APP.BIO.MGT', 'APPLIED BIOLOGY: MANAGEMENT', 5),
            array('RSC.BS.APP.BIO.NTR', 'APPLIED BIOLOGY: NUTRITION SCIENCE', 5),
            array('RSC.BS.APP.BIO.OTH', 'APPLIED BIOLOGY LEADING TO OTH', 5),
            array('RSC.BS.APP.BIO.PBH', 'APPLIED BIOLOGY (BIOLOGY/PUBLIC HEALTH)', 5),
            array('RSC.BS.APP.BIO.PMD', 'APPLIED BIOLOGY: PRE-MED/PRE-PHYSICIAN ASST', 5),
            array('RSC.BS.APP.BIO.PTY', 'APPLIED BIOLOGY: PHYSICAL THERAPY', 5),
            array('RSC.BS.APP.BIO.SCI', 'APPLIED BIOLOGY: SCIENCE WRITING', 5),
            array('RSC.BS.ART', 'STUDIO ART', 23),
            array('RSC.BS.BIO', 'BIOLOGY (BS DEGREE)', 5),
            array('RSC.BS.BIOCHM.ACS', 'BIOCHEMISTRY (ACS CERTIFIED)', 29),
            array('RSC.BS.BIOCHM.NON', 'BIOCHEMISTRY (NON-CERTIFIED)', 29),
            array('RSC.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
            array('RSC.BS.BUS.ADM.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
            array('RSC.BS.BUS.ADM.MSHSA', 'BUSINESS ADMINISTRATION', 21),
            array('RSC.BS.BUS.ADM.MSMBA', 'BUSINESS ADMINISTRATION', 21),
            array('RSC.BS.BUS.ADM.MSORG', 'BUSINESS ADMINISTRATION', 21),
            array('RSC.BS.BUS.ADM.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
            array('RSC.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('RSC.BS.CE.ENG', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.ENG.MSLIT', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.ENG.MSLSP', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.ENG.MSSCP', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.ENG.MSSED', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.HIS', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.HIS.MSLIT', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.HIS.MSLSP', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.HIS.MSSCP', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.HIS.MSSED', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.LFS', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.LFS.MSLIT', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.LFS.MSLSP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.LFS.MSSCP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.LFS.MSSED', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.MAT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.MAT.MSLIT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.MAT.MSLSP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.MAT.MSSCP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.MAT.MSSED', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.PSY', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.PSY.MSLIT', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CE.PSY.MSSED', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
            array('RSC.BS.CHM.ASC', 'CHEMISTRY (ACS CERTIFIED)', 29),
            array('RSC.BS.CHM.NON', 'CHEMISTRY (NON-CERTIFIED)', 29),
            array('RSC.BS.CHM.PTH', 'CHEMISTRY LEADING TO PTH', 29),
            array('RSC.BS.CHME.PTH', 'CHEMISTRY EVEN YEAR LEADING TO PTH', 29),
            array('RSC.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
            array('RSC.BS.CMCE.ENG', 'ENGLISH CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('RSC.BS.CMCE.HIS', 'HIST CHILDHOOD EDUC & SOC STUD MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('RSC.BS.CMCE.MAT', 'MATH CHILDHOOD EDUC & MATH MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('RSC.BS.CMCE.NS', 'NATURAL SCIENCE CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (GEN)', 30),
            array('RSC.BS.FOR.SCI.BIO', 'DOUBLE MJR: FORENSIC SCI & BIOLOGY', 29),
            array('RSC.BS.FOREN.CHM.NON', 'DOUBLE MAJOR: FORENSIC SCIENCE & CHEMISTRY NON CERT', 29),
            array('RSC.BS.FOREN.SCI', 'FORENSIC SCIENCE', 32),
            array('RSC.BS.HSC', 'HEALTH SCIENCE', 33),
            array('RSC.BS.HSC.4OTH', 'HEALTH SCIENCE', 33),
            array('RSC.BS.HSC.4PTH', 'HEALTH SCIENCE', 33),
            array('RSC.BS.HSC.OTH', 'HEALTH SCIENCE LEADING TO OTH', 33),
            array('RSC.BS.HSC.PTH', 'HEALTH SCIENCE LEADING TO DPT', 33),
            array('RSC.BS.INTER.CHSS', 'INTER MJR: COMMUNITY HEALTH & SOCIAL SERVICES', 11),
            array('RSC.BS.INTER.HEL.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
            array('RSC.BS.INTER.HES.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
            array('RSC.BS.INTER.HET.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
            array('RSC.BS.INTER.HEW.OTH', 'INTER MJR: HEALTH & WELLNESS STUDIES LEADING TO OTH', 11),
            array('RSC.BS.INTER.HLS.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
            array('RSC.BS.INTER.HLTH', 'INTER MJR: HEALTH STUDIES', 11),
            array('RSC.BS.INTER.HS.WELL', 'INTER MJR: HEALTH STUDIES: COGNITIVE/KINESTHETIC', 11),
            array('RSC.BS.INTER.HSO.OTH', 'INTER MJR: HEALTH & SOCIETY LEADING TO OTH', 11),
            array('RSC.BS.INTER.HUH.OTH', 'INTER MJR: HUMAN HEALTH & WELLNESS LEADING TO OTH', 11),
            array('RSC.BS.INTER.HWL.OTH', 'INTER MJR: HEALTH & WELLNESS LEADING TO OTH', 11),
            array('RSC.BS.INTER.MAT.EDU', 'INTER MJR: MATHEMATICS & EDUCATION STUDIES', 11),
            array('RSC.BS.INTER.PSC.POL', 'INTER MJR: POLITICS & POLICY', 11),
            array('RSC.BS.INTERDIS', 'RUSSELL SAGE INTERDISCIPLINARY MAJOR FOR ADMISSIONS', 11),
            array('RSC.BS.INTERDIS.4OTH', 'INTERDISCIPLINARY STUDIES', 11),
            array('RSC.BS.INTERDIS.4PTH', 'INTERDISCIPLINARY STUDIES', 11),
            array('RSC.BS.INTERDIS.OTH', 'RSC OTH INTERDISCIPLINARY STUDIES FOR ADMISSIONS', 11),
            array('RSC.BS.LAWSOC.CRM', 'LAW & SOCIETY - CRIMINAL JUSTICE PATHWAY', 34),
            array('RSC.BS.LAWSOC.LGL', 'LAW & SOCIETY - LEGAL PATHWAY', 34),
            array('RSC.BS.LAWSOC.PSY', 'LAW & SOCIETY - PSYCHOLOGY PATHWAY', 34),
            array('RSC.BS.MAT.CIS', 'DOUBLE MJR: MATHEMATICS & COMPUTER INFO SYSTEMS', 35),
            array('RSC.BS.MUS.THR', 'MUSICAL THEATRE', 20),
            array('RSC.BS.NSG.BASIC', 'NURSING (BASIC)', 36),
            array('RSC.BS.NTR', 'NUTRITION', 37),
            array('RSC.BS.NTR.MSNTR', 'NUTRITION', 37),
            array('RSC.BS.PHYS.ED', 'PHYSICAL EDUCATION', 30),
            array('RSC.BS.PHYS.ED.MSSHE', 'PHYSICAL EDUCATION', 30),
            array('RSC.BS.PUBL.POLICY', 'PUBLIC AFFAIRS & PUBLIC POLICY', 38),
            array('RSC.BS.WCT.PHL', 'WRITING & CONTEMPORARY THOUGHT: PRACTICAL PHILOSOPHY', 2),
            array('RSC.BS.WCT.WRIT', 'WRITING & CONTEMPORARY THOUGHT: WRITING', 2),
            array('RSC.NONMATRIC', 'RUSSELL SAGE COLLEGE NONMATRIC', 28),
            array('SCA.BA.BIO', 'BIOLOGY (BA DEGREE)', 5),
            array('SCA.BA.BIO.4OTH', 'BIOLOGY', 5),
            array('SCA.BA.BIO.4PTH', 'BIOLOGY', 5),
            array('SCA.BA.BIO.ENVS', 'BIOLOGY WITH ENVIRONMENTAL SCIENCE CONCENTRATION', 5),
            array('SCA.BA.BIO.OTH', 'BIOLOGY LEADING TO THE MS IN OTH', 5),
            array('SCA.BA.BIO.PTH', 'BIOLOGY LEADING TO PTH', 5),
            array('SCA.BA.CAT.ART', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN VISUAL ART', 6),
            array('SCA.BA.CAT.ART.4OTH', 'CREATIVE ARTS THERAPY WITH ART CONCENTRATION', 6),
            array('SCA.BA.CAT.ART.CHL', 'CREATIVE ARTS THERAPY: ART - CHILD LIFE SPECIALIST', 6),
            array('SCA.BA.CAT.ART.OTH', 'CREATIVE ARTS THERAPY - ART LEADING TO OTH', 6),
            array('SCA.BA.CAT.DAN', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN DANCE', 6),
            array('SCA.BA.CAT.DAN.CHL', 'CREATIVE ARTS THERAPY: DANCE - CHILD LIFE SPECIALIST', 6),
            array('SCA.BA.CAT.DAN.OTH', 'CREATIVE ARTS THERAPY - DANCE LEADING TO OTH', 6),
            array('SCA.BA.CAT.MUS', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN MUSIC', 6),
            array('SCA.BA.CAT.MUS.CHL', 'CREATIVE ARTS THERAPY: MUSIC - CHILD LIFE SPECIALIST', 6),
            array('SCA.BA.CAT.MUS.OTH', 'CREATIVE ARTS THERAPY - MUSIC LEADING TO OTH', 6),
            array('SCA.BA.CAT.THR', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN THEATRE', 6),
            array('SCA.BA.CAT.THR.CHL', 'CREATIVE ARTS THERAPY: THEATRE - CHILD LIFE SPECIALIST', 6),
            array('SCA.BA.CAT.THR.OTH', 'CREATIVE ARTS THERAPY - THEATRE LEADING TO OTH', 6),
            array('SCA.BA.ENG', 'ENGLISH', 9),
            array('SCA.BA.ENG.OTH', 'ENG LEADING TO MS IN OTH', 9),
            array('SCA.BA.ENG.PTH', 'ENGLISH LEADING TO PTH', 9),
            array('SCA.BA.ENVIR.STU', 'ENVIRONMENTAL STUDIES', 11),
            array('SCA.BA.HIS', 'HISTORY', 13),
            array('SCA.BA.HIS.AMS', 'HISTORY: AMERICAN STUDIES PATHWAY', 13),
            array('SCA.BA.HIS.IGS', 'HISTORY WITH INTERNATIONAL GLOBALIZATION PATHWAY', 13),
            array('SCA.BA.HIS.PUH', 'HISTORY: PUBLIC HISTORY PATHWAY', 13),
            array('SCA.BA.MAT', 'MATHEMATICS', 15),
            array('SCA.BA.MAT.4OTH', 'MATHEMATICS', 15),
            array('SCA.BA.MAT.EG', 'MATHEMATICS (FOR ENGINEERING OPTION AT RPI)', 15),
            array('SCA.BA.PACE', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT', 16),
            array('SCA.BA.PACE.PBH', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMNT: PUBLIC HEALTH', 17),
            array('SCA.BA.POL', 'POLITICAL SCIENCE', 16),
            array('SCA.BA.PSY', 'PSYCHOLOGY', 18),
            array('SCA.BA.PSY.4OTH', 'PSYCHOLOGY', 18),
            array('SCA.BA.PSY.4PTH', 'PSYCHOLOGY', 18),
            array('SCA.BA.PSY.OTH', 'PSYCHOLOGY LEADING TO MS IN OTH', 18),
            array('SCA.BA.PSY.PTH', 'PSYCHOLOGY LEADING TO PTH', 18),
            array('SCA.BA.SOC', 'SOCIOLOGY', 19),
            array('SCA.BA.SOC.CRJ', 'SOCIOLOGY WITH CRIME & JUSTICE', 19),
            array('SCA.BA.SOC.OTH', 'SOCIOLOGY LEADING TO MS IN OTH', 19),
            array('SCA.BA.SOC.PBH', 'SOCIOLOGY WITH PUBLIC HEALTH', 19),
            array('SCA.BA.SOC.PTH', 'SOCIOLOGY LEADING TO PTH', 19),
            array('SCA.BA.THR', 'THEATRE', 20),
            array('SCA.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('SCA.BBA.BUS.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
            array('SCA.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCA.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCA.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCA.BBA.BUS.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
            array('SCA.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('SCA.BFA.ART', 'BFA FINE ARTS', 23),
            array('SCA.BFA.ART.MSMAT', 'BFA FINE ARTS', 23),
            array('SCA.BFA.ART.PHG', 'BFA FINE ARTS W/PHOTOGRAPHY CONCENTRATION', 26),
            array('SCA.BFA.GMD', 'BFA GRAPHIC & MEDIA DESIGN', 23),
            array('SCA.BFA.IND', 'BFA IN INTERIOR DESIGN', 25),
            array('SCA.BFA.PHG', 'BFA PHOTOGRAPHY', 26),
            array('SCA.BS.ACC', 'ACCOUNTING', 27),
            array('SCA.BS.ACC.MSMBA', 'ACCOUNTING', 27),
            array('SCA.BS.AEX', 'ACADEMIC EXPLORATION', 28),
            array('SCA.BS.APP.BIO', 'APPLIED BIOLOGY', 5),
            array('SCA.BS.APP.BIO.4OTH', 'APPLIED BIOLOGY', 5),
            array('SCA.BS.APP.BIO.4PTY', 'APPLIED BIOLOGY', 5),
            array('SCA.BS.APP.BIO.ENV', 'APPLIED BIOLOGY: ENVIRONMENTAL SCIENCE', 5),
            array('SCA.BS.APP.BIO.FBI', 'APPLIED BIOLOGY (BIOLOGY/FORENSIC BIOLOGY)', 5),
            array('SCA.BS.APP.BIO.ILL', 'APPLIED BIOLOGY: ILLUSTRATION', 5),
            array('SCA.BS.APP.BIO.L&S', 'APPLIED BIOLOGY: LAW & SOCIETY', 5),
            array('SCA.BS.APP.BIO.MGT', 'APPLIED BIOLOGY: MANAGEMENT', 5),
            array('SCA.BS.APP.BIO.NTR', 'APPLIED BIOLOGY: NUTRITION SCIENCE', 5),
            array('SCA.BS.APP.BIO.OTH', 'APPLIED BIOLOGY LEADING TO OTH', 5),
            array('SCA.BS.APP.BIO.PBH', 'APPLIED BIOLOGY (BIOLOGY/PUBLIC HEALTH)', 5),
            array('SCA.BS.APP.BIO.PMD', 'APPLIED BIOLOGY: PRE-MED/PRE-PHYSICIAN ASST', 5),
            array('SCA.BS.APP.BIO.PTY', 'APPLIED BIOLOGY: PHYSICAL THERAPY', 5),
            array('SCA.BS.APP.BIO.SCI', 'APPLIED BIOLOGY: SCIENCE WRITING', 5),
            array('SCA.BS.ART', 'STUDIO ART', 23),
            array('SCA.BS.BIO', 'BIOLOGY (B.S. DEGREE)', 5),
            array('SCA.BS.BIOCHM.ACS', 'BIOCHEMISTRY (ACS CERTIFIED)', 29),
            array('SCA.BS.BIOCHM.NON', 'BIOCHEMISTRY (NON-CERTIFIED)', 29),
            array('SCA.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
            array('SCA.BS.BUS.ADM.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
            array('SCA.BS.BUS.ADM.MSHSA', 'BUSINESS ADMINISTRATION', 22),
            array('SCA.BS.BUS.ADM.MSMBA', 'BUSINESS ADMINISTRATION', 22),
            array('SCA.BS.BUS.ADM.MSORG', 'BUSINESS ADMINISTRATION', 22),
            array('SCA.BS.BUS.ADM.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
            array('SCA.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('SCA.BS.CE.ENG', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.ENG.MSLIT', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.ENG.MSLSP', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.ENG.MSSCP', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.ENG.MSSED', 'ENGLISH CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.HIS', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.HIS.MSLIT', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.HIS.MSLSP', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.HIS.MSSCP', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.HIS.MSSED', 'HISTORY CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.LFS', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.LFS.MSLIT', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.LFS.MSLSP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.LFS.MSSCP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.LFS.MSSED', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.MAT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.MAT.MSLIT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.MAT.MSLSP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.MAT.MSSCP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CE.MAT.MSSED', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
            array('SCA.BS.CHM.ACS', 'CHEMISTRY ACS CERTIFIED', 29),
            array('SCA.BS.CHM.NON', 'CHEMISTRY (NON-CERTIFIED)', 29),
            array('SCA.BS.CHM.PTH', 'CHEMISTRY LEADING TO PTH', 29),
            array('SCA.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
            array('SCA.BS.CLI.BIO.CYTO', 'BS CLINICAL BIOLOGY LEADING TO CYTOTECHNOLOGY CERT', 5),
            array('SCA.BS.CLI.BIO.LAB', 'BS CLINICAL BIOLOGY LEADING TO CLINICAL LAB SCI CERT', 5),
            array('SCA.BS.CMCE.ENG', 'ENGLISH CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('SCA.BS.CMCE.HIS', 'HIST CHILDHOOD EDUC & SOC STUD MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('SCA.BS.CMCE.MAT', 'MATH CHILDHOOD EDUC & MATH MIDDLE CHILDHOOD EDUC (SPEC)', 30),
            array('SCA.BS.CMCE.NS', 'NATURAL SCIENCE CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (GEN)', 30),
            array('SCA.BS.CREAT.STU.WRT', 'CREATIVE STUDIES - WRITING EMPHASIS', 2),
            array('SCA.BS.FOREN.SCI', 'FORENSIC SCIENCE', 32),
            array('SCA.BS.HSC', 'HEALTH SCIENCES', 33),
            array('SCA.BS.HSC.4OTH', 'HEALTH SCIENCE', 33),
            array('SCA.BS.HSC.4PTH', 'HEALTH SCIENCE', 33),
            array('SCA.BS.HSC.OTH', 'HEALTH SCIENCE LEADING TO OTH', 33),
            array('SCA.BS.HSC.PTH', 'HEALTH SCIENCE LEADING TO DPT', 33),
            array('SCA.BS.INTER.ENG.PSY', 'INTER MJR: ENGLISH & PSYCHOLOGY STUDIES', 11),
            array('SCA.BS.INTER.PSY.ART', 'INTER MJR: PSYCHOLOGY & VISUAL ART STUDIES', 11),
            array('SCA.BS.INTER.PSY.EGL', 'INTER MJR: PSYCHOLOGY & ENGLISH STUDIES', 11),
            array('SCA.BS.INTER.PYMGT', 'INTER MJR: PSYCHOLOGY & MANAGEMENT STUDIES', 11),
            array('SCA.BS.INTERDIS', 'INTERDISCIPLINARY STUDIES', 11),
            array('SCA.BS.INTERDIS.4OTH', 'INTERDISCIPLINARY STUDIES', 11),
            array('SCA.BS.INTERDIS.4PTH', 'INTERDISCIPLINARY STUDIES', 11),
            array('SCA.BS.LAWSOC.CRM', 'LAW & SOCIETY - CRIMINAL JUSTICE PATHWAY', 34),
            array('SCA.BS.LAWSOC.LGL', 'LAW & SOCIETY - LEGAL PATHWAY', 34),
            array('SCA.BS.LAWSOC.PSY', 'LAW & SOCIETY - PSYCHOLOGY PATHWAY', 34),
            array('SCA.BS.MUS.THR', 'MUSICAL THEATRE', 20),
            array('SCA.BS.NSG.BASIC', 'NURSING BASIC', 36),
            array('SCA.BS.NTR', 'NUTRITION', 37),
            array('SCA.BS.NTR.MSNTR', 'NUTRITION', 37),
            array('SCA.BS.PHYS.ED', 'PHYSICAL EDUCATION', 30),
            array('SCA.BS.PHYS.ED.MSSHE', 'PHYSICAL EDUCATION', 39),
            array('SCA.BS.PUBL.POLICY', 'PUBLIC AFFAIRS & PUBLIC POLICY', 38),
            array('SCA.BS.WCT.PHL', 'WRITING & CONTEMPORARY THOUGHT: PRACTICAL PHILOSOPHY', 2),
            array('SCA.BS.WCT.WRIT', 'WRITING & CONTEMPORARY THOUGHT: WRITING', 2),
            array('SCA.CERT.LAS', 'CERTIFICATE IN LEGAL STUDIES', 34),
            array('SCA.NONMATRIC', 'SAGE COLLEGE OF ALBANY - NONMATRIC', 28),
            array('SCAC.BA.LIB.STUD.AD', 'LIBERAL STUDIES', 2),
            array('SCAC.BA.LIB.STUD.AM', 'LIBERAL STUDIES (AMERICAN STUDIES EMPHASIS)', 2),
            array('SCAC.BA.LIB.STUD.EN', 'LIBERAL STUDIES (ENGLISH EMPHASIS)', 2),
            array('SCAC.BA.LIB.STUD.ID', 'LIBERAL STUDIES (INDIVIDUAL STUDIES EMPHASIS)', 2),
            array('SCAC.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
            array('SCAC.BBA.BUS.MKT', 'BACHELOR OF BUSINESS ADMINISTRATION - MARKETING', 22),
            array('SCAC.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCAC.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCAC.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
            array('SCAC.BBA.BUS.ONL', 'BACHELOR OF BUSINESS ADMINISTRATION ONLINE', 21),
            array('SCAC.BBA.BUS.ORG', 'BACHELOR OF BUSINESS ADMIN - ORGANIZATIONAL STUDIES', 22),
            array('SCAC.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('SCAC.BS.ACC', 'ACCOUNTING', 27),
            array('SCAC.BS.ACC.MSHSA', 'ACCOUNTING', 22),
            array('SCAC.BS.ACC.MSMBA', 'ACCOUNTING', 22),
            array('SCAC.BS.ACC.MSORG', 'ACCOUNTING', 22),
            array('SCAC.BS.ACC.ONL', 'ACCOUNTING ONLINE', 27),
            array('SCAC.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
            array('SCAC.BS.BUS.ADM.MKT', 'BUSINESS ADMIN - MARKETING', 22),
            array('SCAC.BS.BUS.ADM.ORG', 'BUSINESS ADMIN - ORGANIZATIONAL STUDIES', 22),
            array('SCAC.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
            array('SCAC.BS.BUS.MSHSA', 'BUSINESS ADMINISTRATION', 21),
            array('SCAC.BS.BUS.MSMBA', 'BUSINESS ADMINISTRATION', 22),
            array('SCAC.BS.BUS.MSORG', 'BUSINESS ADMINISTRATION', 22),
            array('SCAC.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
            array('SCAC.BS.CRLJ.POLICY', 'CRIME, LAW & JUSTICE POLICY', 8),
            array('SCAC.BS.CRM.POLICY', 'CRIME & JUSTICE POLICY', 8),
            array('SCAC.BS.INTER.BUS.PY', 'INTER MJR: BUS ADMIN & PSYCHOLOGY STUDIES', 11),
            array('SCAC.BS.INTER.PSYMG', 'INTER MJR: PSYCH & MGT STUDIES', 11),
            array('SCAC.BS.INTERDIS', 'BACHELOR OF SCIENCE IN INTERDISCIPLINARY STUDIES', 28),
            array('SCAC.BS.ITC.CST.ONL', 'INFORMATION TECHN - CYBER SECURITY', 40),
            array('SCAC.BS.LEGAL', 'LEGAL STUDIES', 34),
            array('SCAC.BS.NETWK', 'COMPUTER NETWORK AND SYSTEMS ADMINISTRATION', 31),
            array('SCAC.BS.NSG.RN', 'NURSING (RN)', 36),
            array('SCAC.BS.NSG.RN.MSNSG', 'NURSING RN', 36),
            array('SCAC.BS.NSG.RN.ONL', 'NURSING RN ONLINE', 36),
            array('SCAC.BS.PSY', 'PSYCHOLOGY (BS)', 18),
            array('SCAC.CERT.CST.ONL', 'CYBER SECURITY CERTIFICATE ONLINE', 40),
            array('SCAC.CERT.ITC.ONL', 'INFORMATION TECHN CERTIFICATE ONLINE', 40),
            array('SCAC.CERT.PMD', 'CERT. IN POST-BACCALAUREATE PRE-MEDICAL STUDIES', 5),
            array('SCAC.NONMATRIC', 'SCA: SAW NONMATRIC', 28),
            array('SGS.CERT.ABA', 'APPL BEHAVIOR ANALYSIS POST MASTER\'\'S CERT', 30),
            array('SGS.CERT.ASP', 'ADV CERT: ASSESSMENT & PLANNING', 30),
            array('SGS.CERT.DI', 'DIETETIC INTERNSHIP', 37),
            array('SGS.CERT.DI.ONL', 'DIETETIC INTERNSHIP (ONLINE)', 37),
            array('SGS.CERT.FMH', 'FORENSIC MENTAL HEALTH CERTIFICATE', 18),
            array('SGS.CERT.HSA', 'CERT IN ADV STUDY OF HEALTH SERVICES ADMIN', 41),
            array('SGS.CERT.LIT', 'ADV CERT: LITERACY', 30),
            array('SGS.CERT.NTR', 'POST-BACCALAUREATE CERTIFICATE IN NUTRITION', 37),
            array('SGS.CERT.PMN.ACUTE', 'PMN ACUTE CARE NURSE PRACTITIONER', 36),
            array('SGS.CERT.PMN.ADHLH', 'ADULT HEALTH NURSING', 36),
            array('SGS.CERT.PMN.ADMIN', 'PMN NURSE ADMINISTRATOR/EXECUTIVE', 36),
            array('SGS.CERT.PMN.ADULT', 'PMN ADULT NURSE PRACTITIONER', 36),
            array('SGS.CERT.PMN.AGNP', 'PMN ADULT GERONTOLOGY NURSE PRACTITIONER', 36),
            array('SGS.CERT.PMN.CLINLDR', 'PMN CLINICAL NURSE LEADER/SPECIALIST', 36),
            array('SGS.CERT.PMN.EDUC', 'PMN NURSE EDUCATOR', 36),
            array('SGS.CERT.PMN.FAM', 'PMN FAMILY NURSE PRACTITIONER', 36),
            array('SGS.CERT.PMN.PSYNP', 'PMN PSYCHIATRIC MENTAL HEALTH NURSE PRACTITIONER', 36),
            array('SGS.CERT.PMN.PSYSPEC', 'PMN PSYCHIATRIC MENTAL HEALTH CLINICAL NURSE SPECIALIST', 36),
            array('SGS.CERT.SCP', 'ADV CERT PROFESSIONAL SCHOOL COUNSELING', 42),
            array('SGS.CERT.TEI', 'ADV CERT: TECHNOLOGY INTEGRATION', 30),
            array('SGS.DNS.NSG.LDR', 'NURSING EDUCATION & LEADERSHIP', 36),
            array('SGS.DPT.PHY.THERAPY', 'PHYSICAL THERAPY', 43),
            array('SGS.EDD.EDU.LDR', 'EDUCATIONAL LEADERSHIP', 30),
            array('SGS.MA.COMM.PSY.GEN', 'COMMUNITY PSYCHOLOGY PROGRAM', 18),
            array('SGS.MA.COUNS.COM.FMH', 'COUNSELING & COMMUNITY PSYCH W/ FORENS MENTAL HLTH CERT', 18),
            array('SGS.MA.COUNS.COM.PSY', 'Counseling and Community Psych.', 18),
            array('SGS.MAT.ART', 'MASTER OF ARTS IN TEACHING - ART EDUCATION (K-12)', 30),
            array('SGS.MAT.ENG.AE', 'MASTER OF ARTS IN TEACHING: ENGLISH ADOLESC EDUCATION', 30),
            array('SGS.MBA.BUS.ADM', 'BUSINESS ADMINISTRATION - GENERAL CONCENTRATION', 44),
            array('SGS.MBA.BUS.ADM.FIN', 'BUSINESS ADMIN - FINANCE', 44),
            array('SGS.MBA.BUS.ADM.HRM', 'BUSINESS ADMIN - HUMAN RESOURCES', 44),
            array('SGS.MBA.BUS.ADM.MKT', 'BUSINESS ADMIN - MARKETING', 44),
            array('SGS.MBA.BUS.ADM.ONL', 'BUSINESS ADMINISTRATION ONLINE', 44),
            array('SGS.MBA.BUS.ADM.STRA', 'BUSINESS ADMIN - BUS STRATEGY', 44),
            array('SGS.MBA.JD.BUS.LAW', 'JOINT DEGREE - MBA BUSINESS ADMIN & JD LAW', 44),
            array('SGS.MS.ABA', 'APPLIED BEHAVIOR ANALYSIS & AUTISM', 30),
            array('SGS.MS.APP.NTR', 'APPLIED NUTRITION (MS)', 37),
            array('SGS.MS.APP.NTR.DI', 'APPLIED NUTRITION (MS) WITH DIETETIC INTERNSHIP CERT', 37),
            array('SGS.MS.CHILD.LIT', 'CHILDHOOD EDUCATION/LITERACY CHILDHOOD (1-6)', 30),
            array('SGS.MS.CHILD.SPE', 'CHILDHOOD EDUCATION/SPECIAL EDUCATION CHILDHOOD', 30),
            array('SGS.MS.COM.HLTH.GCH', 'COMMUNITY HEALTH EDUCATION - GREATER COM TR', 30),
            array('SGS.MS.FMH', 'FORENSIC MENTAL HEALTH', 18),
            array('SGS.MS.HLTH.ADM.DI', 'HEALTH SRVCES ADMIN - DIETETIC INTERNSHIP TRACK', 41),
            array('SGS.MS.HLTH.ADM.GNT', 'HEALTH SRVCES ADMIN - GERONTOLOGY TRACK', 41),
            array('SGS.MS.HLTH.ADM.NTHS', 'HLTH SRVCES ADMIN - NON-THESIS OPTION', 41),
            array('SGS.MS.HLTH.ADM.THES', 'HLTH SRVCES ADMIN - THESIS OPTION', 41),
            array('SGS.MS.HSA.NTHS.ONL', 'HEALTH SERVICES ADMINISTRATION - NON THESIS (ONLINE)', 41),
            array('SGS.MS.HSA.THES.ONL', 'HEALTH SERVICES ADMINISTRATION - THESIS (ONLINE)', 41),
            array('SGS.MS.LIT.SPEC.ED', 'LITERACY/SPECIAL EDUCATION', 30),
            array('SGS.MS.MBA.NSG.BUS', 'COMBINED DEGREE - MS NSG AND MBA BUSINESS ADMINISTRATION', 36),
            array('SGS.MS.MTX', 'MASTER\'\'S IN TEACHING EXCELLENCE', 30),
            array('SGS.MS.NSG.AD.GNT.NP', 'ADULT GERONTOLOGY NURSE PRACTITIONER', 36),
            array('SGS.MS.NSG.ADLT.GER', 'ADULT GERIATRIC ADVANCE PRACTICE NURSING', 36),
            array('SGS.MS.NSG.ADLT.HLTH', 'ADULT HEALTH NURSING', 36),
            array('SGS.MS.NSG.ADLT.PRCT', 'ADULT NURSE PRACTITIONER', 36),
            array('SGS.MS.NSG.FAM.MHNP', 'FAMILY PSYCH MENTAL HLTH NURSE PRACTITIONER', 36),
            array('SGS.MS.NSG.FAM.NUR.P', 'FAMILY NURSE PRACTITIONER', 36),
            array('SGS.MS.NSG.PMH', 'PSYCHIATRIC MENTAL HEALTH NURSING CLINICAL NRSE SPCLST', 36),
            array('SGS.MS.ORG.MGT', 'ORGANIZATION MANAGEMENT', 22),
            array('SGS.MS.ORG.MGT.ONL', 'ORGANIZATION MANAGEMENT ONLINE', 22),
            array('SGS.MS.ORG.MGT.PAD', 'ORGANIZATION MANAGEMENT - W/PUBLIC ADMIN CONCENTRATION', 22),
            array('SGS.MS.OTH', 'OCCUPATIONAL THERAPY', 45),
            array('SGS.MS.SCH.HLTH.ED', 'SCHOOL HEALTH EDUCATION', 30),
            array('SGS.MS.SCH.HLTH.PED', 'SCHOOL HEALTH EDUCATION (PED)', 30),
            array('SGS.MS.SCP', 'PROFESSIONAL SCHOOL COUNSELING', 30),
            array('SGS.MSE.CHILD.SPC.ED', 'SPECIAL EDUCATION (CHILDHOOD)', 30),
            array('SGS.MSE.CHILDHD.ED', 'CHILDHOOD EDUCATION', 30),
            array('SGS.MSE.LIT.ED', 'LITERACY EDUCATION', 30),
            array('SGS.NONMATRIC', 'GRADUATE NONMATRIC', 28),
            array('SGS.TDPT.PHY.THERAPY', 'PHYSICAL THERAPY (TRANSITIONAL DPT)', 46),
            array('TSC.AA.BS.CRM', 'CRIMINAL JUSTICE 2 PLUS 2', 8)
        );

        // Loop through the programs
        foreach ($programs as $programArr) {
            $program = new Program();
            $program->code = $programArr[0];
            $program->name = $programArr[1];
            $program->department_id = $programArr[2];
            $program->save();
        }

    }
}