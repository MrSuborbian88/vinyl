import java.awt.*;
import java.awt.event.*;
import java.awt.image.*;
import java.net.*;
import java.util.*;
import javax.swing.*;

import org.htmlparser.*;
import org.htmlparser.util.*;
import com.myjavatools.web.ClientHttpRequest;

/**
 *	VINL Code - Created 04/17/09
 *
 *	This is the Java Code for the Quick Quiz Creator Applet.  To draw it, use the following HTML (pseudo)code:
 *	<applet code="pathname/QuizCreator.class" width=640 height=480>
 *		<param name="courseid" value="#">
 *		<param name="cfgroot" value="http://www.yoursite.com/vinlcodebase/">
 *	</applet>
 *
 *	This code is commented only where necessary so that the user can understand the general structure
 *	Much of the GUI-intensive code, pertaining to javax.swing, java.awt, and java.awt.event, remains
 *	relatively undocumented.  You should familiarize yourself with these packages before trying to edit
 *	the Quick Quiz Creator
 */
public class QuizCreator extends JApplet
{

	// GUI Constants:
	public static final Font FONT = new Font("Arial", Font.PLAIN, 12);
	public static final Font TINY = new Font("Arial", Font.PLAIN, 10);
	public static final BufferedImage SCR_UP, SCR_DOWN, DELETE; // Icons for Drag and Drop Panel

	// Construct Icons raw from Graphics2D
	static
	{
		SCR_UP = new BufferedImage(16, 16, BufferedImage.TYPE_USHORT_555_RGB);
		Graphics2D g2d = SCR_UP.createGraphics();
		g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);

		g2d.setColor(Color.gray);
		g2d.fillRect(0,0,16,16);
		g2d.setColor(Color.black);
		g2d.drawRect(0,0,15,15);
		g2d.setStroke(new BasicStroke(2));
		g2d.drawLine(0,8,8,0);
		g2d.drawLine(8,0,15,8);
		g2d.drawLine(8,0,8,15);
		g2d.dispose();

		SCR_DOWN = new BufferedImage(16, 16, BufferedImage.TYPE_USHORT_555_RGB);
		g2d = SCR_DOWN.createGraphics();
		g2d.drawImage(SCR_UP, 0, 16, 16, 0, 0, 0, 16, 16, null);
		g2d.dispose();

		DELETE = new BufferedImage(16, 16, BufferedImage.TYPE_USHORT_555_RGB);
		g2d = DELETE.createGraphics();
		g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
		g2d.setColor(Color.white); g2d.fillRect(0, 0, 16, 16);
		g2d.setColor(Color.red); g2d.setStroke(new BasicStroke(3.0f));
		g2d.drawLine(0, 0, 16, 16); g2d.drawLine(16, 0, 0, 16);
		g2d.setStroke(new BasicStroke(1)); g2d.setColor(Color.black); g2d.drawRect(0, 0, 15, 15);
		g2d.dispose();
	}

	// PHP Data: (included as arguments to Applet)
	public static int courseID;
	public static String CFGRoot;

	// Universal Data: (Used when building quiz)
	// @see ultimateSubmit()
	public static String categoryName;
	public static ArrayList<Question> questionsArr;

	// GUI Elements
	// These make up the Applet
	public static QuizSpecsPanel QSPECS;
	public static JTabbedPane tabs;
	public static DragAndDropEditor DNDGUI;
	public static JPanel DNDCONTAIN;
	public static QuestionEditor QEDIT;
	public static JPanel QECONTAIN;
	public static JScrollPane QESCONTAIN;

	// Initialization method, called by default at startup
	public void init()
	{
		// Retrieve parameters
		try
		{
			courseID = Integer.parseInt(getParameter("courseid"));
			CFGRoot = getParameter("cfgroot");
		}
		catch (Exception e)
		{
			throw new RuntimeException(e);
		}

		// Initialize Universal Data
		categoryName = "";
		questionsArr = new ArrayList<Question>();

		// Initialize and Configure GUI components
		QSPECS = new QuizSpecsPanel();
		tabs = new JTabbedPane();
		DNDGUI = new DragAndDropEditor();
		DNDCONTAIN = new JPanel();
		DNDCONTAIN.setLayout(new BorderLayout());
		DNDCONTAIN.add(DNDGUI, BorderLayout.CENTER);
		tabs.add("Quiz Layout", DNDCONTAIN);
		QEDIT = new QuestionEditor();
		QESCONTAIN = new JScrollPane(QEDIT, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		QECONTAIN = new JPanel();
		QECONTAIN.setLayout(new BorderLayout());
		QECONTAIN.add(QESCONTAIN, BorderLayout.CENTER);
		tabs.add("Question Editor", QECONTAIN);

		// Add GUI Components to Applet
		getContentPane().setLayout(new BorderLayout());
		getContentPane().add(QSPECS, BorderLayout.NORTH);
		getContentPane().add(tabs);

		// Hack to force maximum size of JPanel DNDCONTAIN
		DNDGUI.setSize(10000, 10000);
		DNDCONTAIN.setSize(10000, 10000);
		validate();
		repaint();
		DNDGUI.init(DNDCONTAIN.getBounds());
	}

	// GUI constants for FontMetric retrieval, in the absence of a local instance
	public static final BufferedImage sample = new BufferedImage(1, 1, BufferedImage.TYPE_USHORT_555_RGB);
	public static final Graphics2D sampleG2D = sample.createGraphics();

	/**
	 *	Method: computeRenderHeight
	 *
	 *	Given the String, Font, maximum width integer (pixels), and indentation for lines after the first (pixels),
	 *	This method computes how much vertical space it will take to render the String on multiple lines
	 */
	public static int computeRenderHeight(String str, Font font, int maxWidth, int indent)
	{
		String primDelim = " \n";
		StringTokenizer tokenizer = new StringTokenizer(str, primDelim, true);
		FontMetrics fm = sampleG2D.getFontMetrics(font);
		int space = fm.stringWidth("  ");
		int newline = fm.getHeight();

		int curX = 2, curY = 2+fm.getAscent();

		String token = null;
		boolean freshLine = true;
		while (tokenizer.hasMoreTokens())
		{
			if (token == null) token = tokenizer.nextToken();
			case1:
			{
				if (token.indexOf(primDelim) != -1)
				{
					if (token.equals("\n"))
					{
						freshLine = true;
						curY += newline;
						curX = 2+indent;
					}
					else curX += space;

					token = null;
					break case1;
				}

				if (curX+fm.stringWidth(token) > maxWidth-2)
				{
					if (!freshLine)
					{
						curY += newline;
						curX = 2+indent;
						freshLine = true;
					}
					else
					{
						String origToken = token;
						while (curX+fm.stringWidth(token) > maxWidth-2)
							token = token.substring(0, token.length()-1);

						curX = 2+indent;
						curY += newline;
						freshLine = true;
						token = origToken.substring(token.length());
					}
				}
				else
				{
					curX += fm.stringWidth(token);
					freshLine = false;
					token = null;
				}
			}
		}

		return curY+fm.getDescent()+2;
	}

	/**
	 *	Method: renderMultiLine
	 *
	 *	Takes a String and renders it at a given base x,y coordinate with a fixed maximum width (pixels)
	 *	Parameters:
	 *		g2d			= The context
	 *		x,y			= Coordinate basis
	 *		str			= The string to be rendered
	 *		font			= The font style to use
	 *		maxWidth 	= The maximum width (pixels) for a line
	 *		indent		= The indentation (pixels) for subsequent lines forced by wrapping
	 *		background	= Background color (simple filled rectangle)
	 *		foreground	= Font color
	 */
	public static void renderMultiLine(Graphics2D g2d, int x, int y, String str, Font font, int maxWidth, int indent, Color background, Color foreground)
	{
		int height = computeRenderHeight(str, font, maxWidth, indent);
		g2d.setColor(background);
		g2d.fillRect(x, y, maxWidth, height);

		g2d.setColor(foreground);
		g2d.setFont(font);

		String primDelim = " \n";
		StringTokenizer tokenizer = new StringTokenizer(str, primDelim, true);
		FontMetrics fm = sampleG2D.getFontMetrics(font);
		int space = fm.stringWidth("  ");
		int newline = fm.getHeight();

		int curX = 2, curY = 2+fm.getAscent();

		String token = null;
		boolean freshLine = true;
		while (tokenizer.hasMoreTokens())
		{
			if (token == null) token = tokenizer.nextToken();
			case1:
			{
				if (token.indexOf(primDelim) != -1)
				{
					if (token.equals("\n"))
					{
						freshLine = true;
						curY += newline;
						curX = 2+indent;
					}
					else curX += space;

					token = null;
					break case1;
				}

				if (curX+fm.stringWidth(token) > maxWidth-2)
				{
					if (!freshLine)
					{
						curY += newline;
						curX = 2+indent;
						freshLine = true;
					}
					else
					{
						String origToken = token;
						while (curX+fm.stringWidth(token) > maxWidth-2)
							token = token.substring(0, token.length()-1);

						g2d.drawString(token, curX+x, curY+y);

						curX = 2+indent;
						curY += newline;
						freshLine = true;
						token = origToken.substring(token.length());
					}
				}
				else
				{
					g2d.drawString(token, curX+x, curY+y);

					curX += fm.stringWidth(token);
					freshLine = false;
					token = null;
				}
			}
		}
	}

	// These strings go in a JComboBox.  User selects one to create a new question of the requested type
	public static final String[] STRING_ARR = {"Add New Question...",
															 "Multiple Choice",
															 "Fill in the Blank",
															 "Numerical"};

	// Class: QuizSpecsPanel
	// Organizer for GUI elements, accepting input on certain settings for the Quiz
	public class QuizSpecsPanel extends JPanel
	{

		public JTextField quizName;
		public JCheckBox shuffleQuiz;
		public JButton submit;
		public JComboBox addQuestion;

		public QuizSpecsPanel()
		{
			setLayout(null);

			JLabel quizLabel = new JLabel("Quiz Name: ");
			quizLabel.setFont(FONT);
			quizName = new JTextField("Enter Quiz Name", 40);
			quizName.setFont(FONT);

			quizLabel.setSize(quizLabel.getPreferredSize());
			quizName.setSize(quizName.getPreferredSize());
			int maxHeight = (int)Math.max(quizLabel.getHeight(), quizName.getHeight());

			quizLabel.setLocation(5, 5+maxHeight-quizLabel.getHeight());
			quizName.setLocation(10+quizLabel.getWidth(), 5+maxHeight-quizName.getHeight());

			shuffleQuiz = new JCheckBox("Shuffle Questions?", false);
			shuffleQuiz.setFont(FONT);
			shuffleQuiz.setSize(shuffleQuiz.getPreferredSize());
			addQuestion = new JComboBox(STRING_ARR);
			addQuestion.setFont(FONT);
			addQuestion.setSize(addQuestion.getPreferredSize());
			addQuestion.addActionListener(new ActionListener()
			{
				public void actionPerformed(ActionEvent ae)
				{
					if (addQuestion.getSelectedItem().equals(STRING_ARR[1]))
					{
						QEDIT.installForm(new MCQuestionForm());
						tabs.setSelectedComponent(QECONTAIN);
					}
					else if (addQuestion.getSelectedItem().equals(STRING_ARR[2]))
					{
						QEDIT.installForm(new SAQuestionForm());
						tabs.setSelectedComponent(QECONTAIN);
					}
					else if (addQuestion.getSelectedItem().equals(STRING_ARR[3]))
					{
						QEDIT.installForm(new NUMQuestionForm());
						tabs.setSelectedComponent(QECONTAIN);
					}
					addQuestion.setSelectedIndex(0);
				}
			});
			int maxHeight2 = (int)Math.max(shuffleQuiz.getHeight(), addQuestion.getHeight());

			shuffleQuiz.setLocation(5, 10+maxHeight+maxHeight2-shuffleQuiz.getHeight());
			addQuestion.setLocation(10+shuffleQuiz.getWidth(), 10+maxHeight+maxHeight2-addQuestion.getHeight());

			setSize(QuizCreator.this.getWidth(), maxHeight2+maxHeight+15);

			submit = new JButton("Submit");
			submit.setFont(FONT);
			submit.setMargin(new Insets(2,2,2,2));
			submit.setSize(submit.getPreferredSize());
			submit.setLocation(getWidth()-5-submit.getWidth(), (getHeight()-submit.getHeight())/2);
			submit.addActionListener(new ActionListener()
			{
				public void actionPerformed(ActionEvent ae)
				{
					ultimateSubmit();
				}
			});

			add(quizName);
			add(quizLabel);
			add(shuffleQuiz);
			add(addQuestion);
			add(submit);

			quizName.requestFocus();
		}

		// Beautiful Hack
		public Dimension getPreferredSize()
		{
			return getSize();
		}

	}

	// Constants for DNDGUI states
	public static final int ABANDONED = 0,
									FROZEN = 1,
									NEUTRAL = 2,
									SCROLL_PRESS = 3,
									DRAG = 4;
	// Space (pixels) between questions and the edges, and questions with each other
	public static final int SPACE = 6;

	// Thread-safe method to Add a question to the Panel, and also the Universal Data
	public void addQuestion(Question question)
	{
		synchronized (questionsArr)
		{
			questionsArr.add(question);
		}
		DNDGUI.repaint();
	}

	// DNDGUI method to release the panel from a FROZEN state
	// FROZEN is invoked when the user double-clicks to edit a question
	public void unfreezeQuestion(Question replace, int index)
	{
		synchronized (questionsArr)
		{
			questionsArr.set(index, replace);
		}

		QEDIT.installForm(null);
		DNDGUI.unfreeze();
		tabs.setSelectedComponent(DNDCONTAIN);
	}

	/** Method no longer in use

	public String valid(String parse)
	{
		for (int i = 0; i < parse.length(); i++)
		{
			char getChar = parse.charAt(i);
			if (getChar == ' ')
			{
				parse = parse.substring(0, i)+"%20"+parse.substring(i+1);
				i += 2;
			}
			else if (getChar == '.')
			{
				parse = parse.substring(0, i)+"&#046;"+parse.substring(i+1);
				i+=2;
			}
		}
		return parse;
	}*/

	/**
	 *	The big cahuna
	 *
	 *	This is method is called when the "Submit" button is pressed
	 *	WARNING! - This method invokes a separate Thread, so by clicking the button multiple times, you
	 *		could cause PHP errors, which cannot possibly be reported by an Applet
	 *		Multithreading necessary to prevent connectTimeOut from failing
	 */
	public void ultimateSubmit()
	{
		// Verify Quiz Name
		categoryName = QSPECS.quizName.getText().trim();
		if (categoryName.equals("") || categoryName.equals("Enter Quiz Name") || categoryName.equals("You must enter a quiz name"))
		{
			QSPECS.quizName.setText("You must enter a quiz name");
			QSPECS.quizName.requestFocus();
			return;
		}

		// Method deprecated, ClientHttpRequest handles text --> HTML-safe text conversions
		//categoryName = valid(categoryName);

		// Create a Progress Window at center screen
		// Each step should take 1.5 - 4 seconds on average
		// n = Number of steps
		final int n = 8;
		Dimension d = Toolkit.getDefaultToolkit().getScreenSize();
		// User normally doesn't see this, because Step 2 occurs almost instantly
		final JFrame progress = new JFrame("Preparing (Step 1 of "+n+")...");
		progress.pack();
		progress.setSize(480, progress.getHeight());
		Dimension dprime = progress.getSize();
		progress.setLocation((d.width-dprime.width)/2, (d.height-dprime.height)/2);
		progress.show();

		// MultiThreading, to prevent EventDispatcher deadlock errors or halting
		// Also ensures that the JFrame progress responds to updates promptly
		Thread t = new Thread() { public void run() {
		try
		{
			progress.setTitle("Getting Category ID (Step 2 of "+n+")...");
			progress.repaint();

			URL url = new URL(CFGRoot + "question/edit.php?courseid=" + courseID);
			URLConnection conn = url.openConnection();
			Parser parse = new Parser(conn);
			RecursiveIterator itr = new RecursiveIterator(parse.elements());

			int category = -314159;
			String fullCategory = null;
			while (itr.hasMoreNodes()) // Ugly hack to retrieve default category ID.  PHP is not friendly
			{
				Node node = itr.nextNode();
				if (node instanceof Tag)
				{
					Tag tag = (Tag)node;
					if (tag.getTagName().equalsIgnoreCase("select") && tag.getAttribute("id") != null && tag.getAttribute("id").equals("catmenu_jump"))
					{
						NodeList list = tag.getChildren();
						for (int i = 0; i < list.size(); i++)
						{
							Node node2 = list.elementAt(i);
							if (node2 instanceof Tag)
							{
								Tag tag2 = (Tag)node2;
								if (tag2.getTagName().equalsIgnoreCase("option") && tag2.getAttribute("selected") != null)
								{
									String getCat = tag2.getAttribute("value");
									getCat = getCat.substring(getCat.indexOf("category=")+9);
									int index = getCat.indexOf(",");
									if (index != -1)
									{
										category = Integer.parseInt(getCat.substring(0,index));
										index = getCat.indexOf("&");
										if (index != -1) fullCategory = getCat.substring(0, index);
										else fullCategory = getCat;
										break;
									}
									index = getCat.indexOf("&");
									if (index != -1)
									{
										category = Integer.parseInt(getCat.substring(0, index));
										fullCategory = getCat.substring(0, index);
										break;
									}
									category = Integer.parseInt(getCat);
									fullCategory = getCat;
									break;
								}
							}
						}
					}
				}
			}
			if (category == -314159) throw new Exception("Failed to acquire category ID");

			int size = -1;
			synchronized (questionsArr)
			{
				size = questionsArr.size();
			}

			progress.setTitle("Acquiring Session Key (Step 3 of "+n+")...");
			progress.repaint();

			url = new URL(CFGRoot + "question/question.php?courseid="+courseID+"&qtype=shortanswer&category="+category);
			conn = url.openConnection();
			parse = new Parser(conn);
			itr = new RecursiveIterator(parse.elements());
			String sessKey = "dieinafire"; // Don't ask
			while (itr.hasMoreNodes()) // Much less ugly hack to retrieve session key
			{
				Node node = itr.nextNode();
				if (node instanceof Tag)
				{
					Tag tag = (Tag)node;
					if (tag.getAttribute("name") != null && tag.getAttribute("name").equals("sesskey"))
					{
						sessKey = tag.getAttribute("value");
						break;
					}
				}
			}
			if (sessKey.equals("dieinafire")) throw new Exception("Failed to acquire sessKey");

			// Add questions, 1 by 1, by submitting form data
			for (int i = 0; i < size; i++)
			{
				progress.setTitle("Creating Question "+(i+1)+" of "+size+" (Step 4 of "+n+")...");
				progress.repaint();

				Question quest = null;
				synchronized (questionsArr)
				{
					quest = questionsArr.get(i);
				}

				String qtype = null;
				MultipleChoice MC = null; ShortAnswer SA = null; Numerical NUM = null;

				if (quest instanceof MultipleChoice)
				{
					MC = (MultipleChoice)quest;
					qtype = "multichoice";
				}
				else if (quest instanceof ShortAnswer)
				{
					SA = (ShortAnswer)quest;
					qtype = "shortanswer";
				}
				else
				{
					NUM = (Numerical)quest;
					qtype = "numerical";
				}

				// This part was not fun
				ArrayList<Object> objects = new ArrayList<Object>();
				objects.add("courseid"); objects.add(""+courseID);
				objects.add("category"); objects.add(fullCategory);
				objects.add("name"); objects.add("QQC_"+categoryName+"_QN_"+(i+1));
				objects.add("qtype"); objects.add(qtype);
				objects.add("id"); objects.add("");
				objects.add("inpopup"); objects.add("0");
				objects.add("versioning"); objects.add("");
				objects.add("movecontext"); objects.add("0");
				objects.add("cmid"); objects.add("0");
				objects.add("_qf__question_edit_"+qtype+"_form"); objects.add("1");
				objects.add("questiontextformat"); objects.add("0");
				objects.add("defaultgrade"); objects.add("1");
				objects.add("penalty"); objects.add("0.1");
				objects.add("usecase"); objects.add("0");
				objects.add("submitbutton"); objects.add("1");
				objects.add("sesskey"); objects.add(sessKey);

				if (qtype.equals("multichoice"))
				{
					int noAnswers = MC.choices.size();

					objects.add("noanswers"); objects.add(""+noAnswers);
					objects.add("questiontext"); objects.add(MC.qText);
					objects.add("shuffleanswers"); objects.add(MC.shuffle ? "0" : "1");
					objects.add("shuffleanswers"); objects.add(MC.shuffle ? "1" : "0");
					objects.add("answernumbering"); objects.add("abc");

					int numcorrect = 0;
					for (MCAnswer MCA : MC.choices) if (MCA.isCorrect) numcorrect++;
					double correct = 1.0/numcorrect;
					objects.add("single"); objects.add((numcorrect == 1) ? "1" : "0");

					for (int j = 0; j < noAnswers; j++)
					{
						MCAnswer MCA = MC.choices.get(j);
						objects.add("answer["+j+"]"); objects.add(MCA.answer);
						objects.add("feedback["+j+"]"); objects.add("");
						objects.add("fraction["+j+"]");
							objects.add((MCA.isCorrect ? correct : -correct)+"");
					}

					objects.add("correctfeedback"); objects.add("");
					objects.add("partiallycorrectfeedback"); objects.add("");
					objects.add("incorrectfeedback"); objects.add("");
				}
				else if (qtype.equals("shortanswer"))
				{
					objects.add("noanswers"); objects.add("1");
					objects.add("answer[0]"); objects.add(SA.answer);
					objects.add("fraction[0]"); objects.add("1");
					objects.add("feedback[0]"); objects.add("");
					objects.add("questiontext"); objects.add(SA.qText);
				}
				else
				{
					objects.add("noanswers"); objects.add("1");
					objects.add("nounits"); objects.add("1");
					objects.add("questiontext"); objects.add(NUM.qText);
					objects.add("answer[0]"); objects.add(""+NUM.answer);
					objects.add("tolerance[0]"); objects.add(""+NUM.linearTolerance);
					objects.add("fraction[0]"); objects.add("1");
					objects.add("unit[0]"); objects.add("");
					objects.add("multiplier[0]"); objects.add("1.0");
				}

				/** Code below obsolete.  Strict HTTP posts are needed to submit form Data, URL reads are not enough

				String newURL = CFGRoot + "question/question.php?";
				for (int j = 0; j < objects.size(); j+=2)
				{
					if (j != 0) newURL += "&";
					newURL += objects.get(j)+"="+valid((String)objects.get(j+1));
				}
				url = new URL(newURL);
				conn = url.openConnection();
				parse = new Parser(conn);
				NodeIterator itr2 = parse.elements();

				while (itr2.hasMoreNodes())
				{
					Node node = itr2.nextNode();
					System.out.println(node.toHtml(true));
				}*/

				controlledPost(CFGRoot+"question/question.php", objects);
			}

			// This step is also practically instanteous, as there are no URL calls, just OO-instantiation
			progress.setTitle("Preparing Quiz Data (Step 4 of "+n+")...");
			progress.repaint();

			ArrayList<Object> objects = new ArrayList<Object>();
			String timeopenday = null, timeopenmonth = null, timeopenyear = null, timeopenhour = null, timeopenminute = null;
			String timecloseday = null, timeclosemonth = null, timecloseyear = null, timeclosehour = null, timecloseminute = null;

			GregorianCalendar greg = new GregorianCalendar();

			timeopenday = timecloseday = ""+greg.get(Calendar.DAY_OF_MONTH);
			timeopenmonth = timeclosemonth = ""+(greg.get(Calendar.MONTH)+1);
			timeopenyear = timecloseyear = ""+greg.get(Calendar.YEAR);
			timeopenhour = timeclosehour = ""+greg.get(Calendar.HOUR_OF_DAY);
			timeopenminute = timecloseminute = ""+greg.get(Calendar.MINUTE);

			/** Parsing of default times ditched in favor of Gregorian Calendar.  Saves the time-costly use of a Parser

			url = new URL(CFGRoot + "course/modedit.php?id="+courseID+"&section=0&sesskey="+sessKey+"&add=quiz");
			conn = url.openConnection();
			parse = new Parser(conn);
			itr = new RecursiveIterator(parse.elements());
			while (itr.hasMoreNodes())
			{
				Node node = itr.nextNode();

				if (node instanceof Tag)
				{
					Tag tag = (Tag)node;
					timeopenday = getSelectedOptionValue(tag, timeopenday, "timeopen[day]");
					timeopenmonth = getSelectedOptionValue(tag, timeopenmonth, "timeopen[month]");
					timeopenyear = getSelectedOptionValue(tag, timeopenyear, "timeopen[year]");
					timeopenhour = getSelectedOptionValue(tag, timeopenhour, "timeopen[hour]");
					timeopenminute = getSelectedOptionValue(tag, timeopenminute, "timeopen[minute]");
					timecloseday = getSelectedOptionValue(tag, timecloseday, "timeclose[day]");
					timeclosemonth = getSelectedOptionValue(tag, timeclosemonth, "timeclose[month]");
					timecloseyear = getSelectedOptionValue(tag, timecloseyear, "timeclose[year]");
					timeclosehour = getSelectedOptionValue(tag, timeclosehour, "timeclose[hour]");
					timecloseminute = getSelectedOptionValue(tag, timecloseminute, "timeclose[minute]");
				}
			}*/

			// This part was even less fun
			// Try sifting through several 100's of lines of HTML to get these, see how you like it
			objects.add("mform_showadvanced_last"); objects.add("");
			objects.add("MAX_FILE_SIZE"); objects.add("16777216");
			objects.add("grade"); objects.add("100");
			objects.add("course"); objects.add(courseID+"");
			objects.add("coursemodule"); objects.add("");
			objects.add("section"); objects.add("0");
			objects.add("module"); objects.add("13");
			objects.add("modulename"); objects.add("quiz");
			objects.add("instance"); objects.add("");
			objects.add("add"); objects.add("quiz");
			objects.add("update"); objects.add("0");
			objects.add("return"); objects.add("0");
			objects.add("boundary_repeats"); objects.add("1");
			objects.add("sesskey"); objects.add(sessKey);
			objects.add("_qf__mod_quiz_mod_form"); objects.add("1");

			objects.add("name"); objects.add(categoryName);
			objects.add("intro"); objects.add("");

			objects.add("timeopen[day]"); objects.add(timeopenday);
			objects.add("timeopen[month]"); objects.add(timeopenmonth);
			objects.add("timeopen[year]"); objects.add(timeopenyear);
			objects.add("timeopen[hour]"); objects.add(timeopenhour);
			objects.add("timeopen[minute]"); objects.add(timeopenminute);
			objects.add("timeopen[off]"); objects.add("1");
			objects.add("timeclose[day]"); objects.add(timecloseday);
			objects.add("timeclose[month]"); objects.add(timeclosemonth);
			objects.add("timeclose[year]"); objects.add(timecloseyear);
			objects.add("timeclose[hour]"); objects.add(timeclosehour);
			objects.add("timeclose[minute]"); objects.add(timecloseminute);
			objects.add("timeclose[off]"); objects.add("1");

			objects.add("timelimit"); objects.add("0");
			objects.add("timelimitenable"); objects.add("1");
			objects.add("delay1"); objects.add("0");
			objects.add("delay2"); objects.add("0");
			objects.add("questionsperpage"); objects.add("10");
			objects.add("shufflequestions"); objects.add(QSPECS.shuffleQuiz.isSelected() ? "1" : "0");
			objects.add("shuffleanswers"); objects.add("1");

			objects.add("attempts"); objects.add("1");
			objects.add("attemptonlast"); objects.add("0");
			objects.add("adaptive"); objects.add("0");
			objects.add("grademethod"); objects.add("1");
			objects.add("penaltyscheme"); objects.add("1");
			objects.add("decimalpoints"); objects.add("2");
			objects.add("submitbutton2"); objects.add("1");

			// Yay Permutation Algorithm!
			String[] perm1 = {"immediately", "open", "closed"};
			String[] perm2 = {"responses", "answers", "feedback", "generalfeedback", "score", "overallfeedback"};
			for (String s1 : perm1) for (String s2 : perm2) { objects.add(s2+s1); objects.add("1"); }

			objects.add("popup"); objects.add("1");
			objects.add("quizpassword"); objects.add("");
			objects.add("subnet"); objects.add("");
			objects.add("groupmode"); objects.add("0");
			objects.add("cmidnumber"); objects.add(""); // In HTML, <input name="cmidnumber"> has no value parameter.  This is problematic
																	  // However, the code seems to work fine like this
			objects.add("visible"); objects.add("1");
			objects.add("gradecat"); objects.add("2"); // In HTML, <select name="gradecat"> has one option tag, value="2", but it is not selected
																	 // As with cmidnumber, this is problematic, but it seems to work fine

			objects.add("feedbacktext[0]"); objects.add("");
			objects.add("feedbackboundaries[0]"); objects.add("");
			objects.add("feedbacktext[1]"); objects.add("");

			// Actually submit the quiz
			// NOTE: The QQC has been known to fail here, for reasons yet unknown
			// Implemented a Threading "hack" in the controlledPost method to overcome it, and it seems to work
			progress.setTitle("Instantiating Quiz (Step 5 of "+n+")...");
			progress.repaint();

			controlledPost(CFGRoot+"course/modedit.php", objects);

			// Harvesting is a pretty word
			// Note: The QQC will fail here if there are over 1000 questions in the default category
			// Note: If there are over 1000 questions, somebody has too much time on their hands
			progress.setTitle("Harvesting Question ID's (Step 6 of "+n+")...");
			progress.repaint();

			url = new URL(CFGRoot + "question/edit.php?qperpage=1000&courseid="+courseID);
			conn = url.openConnection();
			parse = new Parser(conn);
			itr = new RecursiveIterator(parse.elements());

			HashMap<Integer, Integer> map = new HashMap<Integer, Integer>();
			while (itr.hasMoreNodes()) // More ugly Parser hacks...
			{
				Node node = itr.nextNode();
				if (node instanceof Text && node.getParent() != null && node.getParent().getParent() != null &&
					((Text)node).getText().startsWith("QQC_"+categoryName+"_QN_"))
				{
					Tag tag = (Tag)(node.getParent().getParent());
					NodeList children = tag.getChildren();
					if (children == null) continue;
					String txt = ((Text)node).getText();
					Integer qnum = new Integer(Integer.parseInt(txt.substring(txt.lastIndexOf("_")+1)));

					RecursiveIterator itr2 = new RecursiveIterator(children.elements());
					outer: while (itr2.hasMoreNodes())
					{
						Node node2 = itr2.nextNode();
						if (node2 instanceof Tag)
						{
							Tag tag2 = (Tag)node2;
							if (tag2.getTagName().equalsIgnoreCase("a"))
							{
								String link = tag2.getAttribute("href");
								int index = link.indexOf("?id=");
								link = link.substring(index+4);
								link = link.substring(0, link.indexOf("&"));
								Integer qid = new Integer(Integer.parseInt(link));
								map.put(qnum, qid);

								break outer;
							}
						}
					}
				}
			}

			// Retrieve the Quiz ID
			progress.setTitle("Getting Quiz ID (Step 7 of "+n+")...");
			progress.repaint();

			url = new URL(CFGRoot + "course/view.php?id="+courseID);
			conn = url.openConnection();
			parse = new Parser(conn);
			itr = new RecursiveIterator(parse.elements());

			int quizID = -1;
			while (itr.hasMoreNodes()) // More much less ugly Parser hacks...
			{
				Node node = itr.nextNode();
				if (node instanceof Text && ((Text)node).getText().equals(categoryName))
				{
					if (node.getParent() != null && node.getParent().getParent() != null && node.getParent().getParent().getParent() != null)
					{
						Node liverify = node.getParent().getParent().getParent();
						if (liverify instanceof Tag)
						{
							Tag tagv = (Tag)liverify;
							if (!tagv.getTagName().equalsIgnoreCase("LI")) continue;
							if (tagv.getAttribute("class") == null || !tagv.getAttribute("class").equals("activity quiz")) continue;

							Tag link = (Tag)node.getParent().getParent();
							String txt = link.getAttribute("href"); txt = txt.substring(txt.indexOf("=")+1);
							quizID = Integer.parseInt(txt);
						}
					}
				}
			}

			// Add the questions 1 by 1 to the quiz
			for (int i = 1; i <= size; i++)
			{
				progress.setTitle("Adding Question "+i+" of "+size+" (Step 8 of "+n+")...");

				addQuestionToQuiz(quizID+"", map.get(new Integer(i))+"", sessKey);
			}

			progress.dispose();
			JOptionPane.showMessageDialog(QuizCreator.this, "Go to the Course Page to preview/edit your quiz", "Quiz Successfully Created", JOptionPane.INFORMATION_MESSAGE);

			// NOTE:
			// Trying to implement a getAppletContext().showDocument(URL) call to redirect the page here, but a known bug
			// in controlledPost() seems to be getting in the way
		}
		catch (Exception e)
		{
			e.printStackTrace();
			progress.dispose();

			JOptionPane.showMessageDialog(QuizCreator.this, "An error occured:\n"+e, "Error - Sorry :(", JOptionPane.ERROR_MESSAGE);
		} } };
		t.start();
	}

	/**
	 * Method: controlledPost
	 *
	 *	Gut-wrenching hack to compensate for the setConnectTimeout(10000) failure in ClientHttpRequest
	 */
	public void controlledPost(String address, ArrayList<Object> param) throws Exception
	{
		class BoolCapsule
		{
			public volatile boolean value;
		}

		URL url = new URL(address);
		URLConnection conn = url.openConnection();
		final ClientHttpRequest CHR = new ClientHttpRequest(conn);
		final BoolCapsule link = new BoolCapsule();
		link.value = false;

		final ArrayList<Object> PARAM = new ArrayList<Object>(param);
		Thread maxim = new Thread()
		{
			public void run()
			{
				try
				{
					CHR.post((Object[])PARAM.toArray());
					link.value = true;
				}
				catch (Exception e) // This will ALWAYS happen if the connection succeeds
										  // This is caused by a "strictRedirect" error when the Form post is made
										  // HTML wants to forcibly change the page URL, but the Applet doesn't let this happen
										  // No known way around this exception catching hack
				{
					link.value = true;
					// I ignore you
				}
			}
		};

		maxim.start();

		long prev = System.currentTimeMillis();
		while ((System.currentTimeMillis()-prev) < 10000 && !link.value)
			try { Thread.sleep(100); } catch (InterruptedException ie) { }

		maxim.stop();
	}

	// Auxiliary method for adding questions to the Quiz, used in ultimateSubmit()
	public void addQuestionToQuiz(String quizid, String questid, String sessKey) throws Exception
	{
		//Requires a quiz id in quizid
		//Requires a question id in questid
		//Requires a session key in sesskey

		ArrayList<Object> questobjects = new ArrayList<Object>();
		questobjects.add("cmid"); questobjects.add(quizid);
		questobjects.add("addquestion"); questobjects.add(questid);
		questobjects.add("sesskey"); questobjects.add(sessKey);

		controlledPost(CFGRoot+"mod/quiz/edit.php", questobjects);
	}

	/** Method unnecessary - see GregorianCalendar in ultimateSubmit()

	public String getSelectedOptionValue(Tag tag, String prev, String reqName) throws Exception
	{
		if (prev != null) return prev;
		if (tag.getTagName().equalsIgnoreCase("SELECT") && tag.getAttribute("name") != null && tag.getAttribute("name").equals(reqName))
		{
			RecursiveIterator itr2 = new RecursiveIterator(tag.getChildren().elements());
			while (itr2.hasMoreNodes())
			{
				Node node2 = itr2.nextNode();
				if (node2 instanceof Tag)
				{
					Tag tag2 = (Tag)node2;
					if (tag2.getTagName().equalsIgnoreCase("OPTION") && tag2.getAttribute("selected") != null)
					{
						return tag2.getAttribute("value");
					}
				}
			}
		}
		return prev;
	}*/

	/**
	 *	Class: DragAndDropEditor
	 *
	 *	Manual Drag-and-drop interface for modifying the order of a quiz
	 *	Drag to the top-left to delete stuff
	 *
	 *	No comments in this class: This is hardcore Graphics, GUI, and awt.event stuff
	 *	I.E., if I need to explain it to you, you wouldn't understand anyway
	 */
	public class DragAndDropEditor extends JPanel implements MouseListener, MouseMotionListener
	{

		public int WIDTH, HEIGHT;
		public boolean initialized = false;

		public int scrollY;
		public BufferedImage canvas;
		public Graphics2D g2d;
		public int state;

		public int mouseX, mouseY;
		public int mouseCaptureX, mouseCaptureY;
		public int transientIndex;
		public int replacementIndex;
		public int scrollFocus;

		public void init(Rectangle dim)
		{
			WIDTH = dim.width;
			HEIGHT = dim.height;
			scrollY = 0;

			state = ABANDONED;

			mouseX = -1;
			mouseY = -1;
			mouseCaptureX = 0;
			mouseCaptureY = 0;
			transientIndex = -1;
			replacementIndex = -1;
			scrollFocus = -1;

			initialized = true;

			setBounds(0, 0, WIDTH, HEIGHT);

			canvas = new BufferedImage(WIDTH, HEIGHT, BufferedImage.TYPE_USHORT_555_RGB);
			g2d = canvas.createGraphics();
			g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);

			addMouseListener(this);
			addMouseMotionListener(this);
		}

		public void paintComponent(Graphics g)
		{
			if (!initialized) return;

			g2d.setColor(new Color(0xc0c0c0));
			g2d.fillRect(0, 0, WIDTH, HEIGHT);

			int full = full();
			if (scrollY < 0) scrollY = 0;
			else if (full > HEIGHT && scrollY+HEIGHT > full) scrollY = full-HEIGHT;

			synchronized (questionsArr)
			{
				int curY = SPACE-scrollY;

				for (int i = 0; i < questionsArr.size(); i++)
				{
					Question quest = questionsArr.get(i);
					int height = quest.computeHeight(WIDTH-2*SPACE);

					if (curY + height >= 0 || curY <= HEIGHT)
					{
						boolean alpha = ((transientIndex == i) && (state == FROZEN || state == DRAG));
						boolean lineRender = (replacementIndex != transientIndex) && (replacementIndex == i);

						Color color = Color.black;
						if (transientIndex == i)
						{
							if (state == FROZEN) color = Color.red;
							else if (state == NEUTRAL) color = Color.blue;
							else if (state == DRAG) color = new Color(0x404040);

							if (state == DRAG && replacementIndex == i) color = Color.green;
						}

						quest.render(g2d, SPACE, curY, WIDTH-16-2*SPACE, alpha, lineRender, color);
					}

					curY += height + SPACE;
				}

				if (state == DRAG)
				{
					if (replacementIndex != -1)
					{
						questionsArr.get(transientIndex).render(g2d, mouseX-mouseCaptureX, mouseY-mouseCaptureY,
																			 WIDTH-16-2*SPACE, true, false, Color.red);
						g2d.setComposite(AlphaComposite.getInstance(AlphaComposite.SRC_OVER, 0.7f));
						g2d.drawImage(DELETE, 0, 0, null);
						g2d.setComposite(AlphaComposite.SrcOver);
					}
					else g2d.drawImage(DELETE, 0, 0, null);

					if (replacementIndex == questionsArr.size())
					{
						g2d.setColor(Color.green);
						g2d.setStroke(new BasicStroke(2));
						g2d.drawLine(SPACE/2, full-scrollY-SPACE/2, WIDTH-16-SPACE/2, full-scrollY-SPACE/2);
					}
				}
			}

			g2d.setStroke(new BasicStroke(1));

			g2d.drawImage(SCR_UP, WIDTH-16, 0, null);
			g2d.drawImage(SCR_DOWN, WIDTH-16, HEIGHT-16, null);
			g2d.setColor(Color.darkGray);
			g2d.fillRect(WIDTH-16, 16, 16, HEIGHT-32);
			g2d.setColor(Color.black);
			g2d.drawLine(WIDTH-16, 16, WIDTH-16, HEIGHT-16);
			g2d.drawLine(WIDTH-1, 16, WIDTH-1, HEIGHT-16);

			g2d.setStroke(new BasicStroke(2.5f));

			if (HEIGHT < full)
			{
				g2d.setColor(Color.lightGray);
				g2d.fillRect(WIDTH-16, 16+scrollY*(HEIGHT-32)/full, 16, HEIGHT*(HEIGHT-32)/full);
				g2d.setColor(((state == NEUTRAL || state == SCROLL_PRESS) && (scrollFocus == 1)) ? Color.blue : Color.black);
				g2d.drawRect(WIDTH-16, 16+scrollY*(HEIGHT-32)/full, 15, HEIGHT*(HEIGHT-32)/full - 1);
			}
			if ((state == NEUTRAL || state == SCROLL_PRESS) && (scrollFocus == 0 || scrollFocus == 2))
			{
				g2d.setColor(Color.blue);
				g2d.drawRect(WIDTH-16, scrollFocus*(HEIGHT-16)/2, 15, 15);
			}
			if ((state == NEUTRAL || state == SCROLL_PRESS) && (scrollFocus == 3))
			{
				g2d.setColor(Color.blue);
				g2d.drawRect(WIDTH-16, 16, 15, HEIGHT-33);
			}

			g2d.setColor(Color.gray);

			if (state == FROZEN)
			{
				g2d.setColor(new Color(0x80c0c0c0, true));
				g2d.fillRect(0, 0, WIDTH, HEIGHT);
			}

			g.drawImage(canvas, 0, 0, null);
		}

		public int questionIndex(Point arg)
		{
			Point mousePoint = new Point(arg.x, arg.y);

			if (mousePoint.x < 0) mousePoint.x = 0;
			if (mousePoint.x >= WIDTH) mousePoint.x = WIDTH-1;
			if (mousePoint.y < 0) mousePoint.y = 0;
			if (mousePoint.y >= HEIGHT) mousePoint.y = HEIGHT-1;

			if (mousePoint.x < SPACE-1 || mousePoint.x > WIDTH-16-SPACE+1) return -1;

			int curY = SPACE-scrollY;
			int i = 0;

			synchronized (questionsArr)
			{
				while (i < questionsArr.size())
				{
					curY += SPACE+questionsArr.get(i).computeHeight(WIDTH-16-2*SPACE);
					if (curY-1 > mousePoint.y)
					{
						curY -= SPACE+questionsArr.get(i).computeHeight(WIDTH-16-2*SPACE);
						break;
					}
					i++;
				}
				if (i == questionsArr.size()) i = -1;
				else if (mousePoint.y-curY+1-questionsArr.get(i).computeHeight(WIDTH-16-2*SPACE) > 0) i = -1;
			}

			return i;
		}
		public int getScrollFocus(Point arg)
		{
			Point mousePoint = new Point(arg.x, arg.y);

			if (mousePoint.x < 0) mousePoint.x = 0;
			if (mousePoint.x >= WIDTH) mousePoint.x = WIDTH-1;
			if (mousePoint.y < 0) mousePoint.y = 0;
			if (mousePoint.y >= HEIGHT) mousePoint.y = HEIGHT-1;

			if (mousePoint.x < WIDTH-16) return -1;
			else
			{
				if (mousePoint.y <= 16) return 0;
				if (mousePoint.y >= HEIGHT-16) return 2;

				int full = full();
				int ybase = 16+scrollY*(HEIGHT-32)/full;
				int height = HEIGHT*(HEIGHT-32)/full;

				if (mousePoint.y >= ybase && mousePoint.y <= ybase+height) return 1;
				else return 3;
			}
		}
		public boolean scrollOffAbove(int y)
		{
			if (y < 0) y = 0;
			if (y >= HEIGHT) y = HEIGHT-1;

			int full = full();
			int ybase = 16+scrollY*(HEIGHT-32)/full;

			if (y < ybase) return true;
			else return false;
		}
		public int full()
		{
			int sum = SPACE;
			synchronized (questionsArr)
			{
				for (Question quest : questionsArr) sum += SPACE+quest.computeHeight(WIDTH-16-2*SPACE);
			}

			return sum;
		}

		public long doubleClickRecord = -1;
		public int clickIndex = -1;
		public void unfreeze()
		{
			state = ABANDONED;
			mouseCaptureX = mouseCaptureY = transientIndex = replacementIndex = scrollFocus = -1;
			doubleClickRecord = clickIndex = -1;
			imminentDrag = false;
		}

		public boolean imminentDrag = false;
		public Point origClick = null;

		public void mouseClicked(MouseEvent me)
		{

		}
		public Thread dragThread;
		public void mouseDragged(MouseEvent me)
		{
			if (state == FROZEN) return;

			if (state == SCROLL_PRESS && scrollFocus == 1)
			{
				int full = full();
				int relativeScroll = (me.getPoint().y - origClick.y)*full/(HEIGHT-32);

				if (relativeScroll != 0)
				{
					scrollY = mouseCaptureY+relativeScroll;
					if (scrollY < 0) scrollY = 0;
					if (scrollY+HEIGHT > full) scrollY = full-HEIGHT;
					repaint();
				}
			}
			if (state == NEUTRAL && imminentDrag)
			{
				int absDist = (int)Math.max(Math.abs(me.getPoint().x-origClick.x),Math.abs(me.getPoint().y-origClick.y));
				if (absDist >= 10)
				{
					imminentDrag = false;
					state = DRAG;

					mouseCaptureX = origClick.x-SPACE;
					mouseCaptureY = origClick.y+scrollY-SPACE;

					mouseX = me.getPoint().x;
					mouseY = me.getPoint().y;

					synchronized (questionsArr)
					{
						for (int i = 0; i < transientIndex; i++)
							mouseCaptureY -= SPACE+questionsArr.get(i).computeHeight(WIDTH-16-2*SPACE);
					}

					replacementIndex = transientIndex;
					scrollFocus = -1;

					dragThread = new Thread()
					{
						public void run()
						{
							while (true)
							{
								if (mouseX > 16 || mouseY > 16)
								{
									boolean repaint = true;
									if (mouseY < 10) scrollY -= 50;
									else if (mouseY < 30) scrollY -= 20;
									else if (mouseY < 50) scrollY -= 5;
									else if (mouseY > HEIGHT-10) scrollY += 50;
									else if (mouseY > HEIGHT-30) scrollY += 20;
									else if (mouseY > HEIGHT-50) scrollY += 5;
									else repaint = false;

									int full = full();
									if (scrollY < 0) scrollY = 0;
									else if (full > HEIGHT && scrollY+HEIGHT > full) scrollY = full-HEIGHT;

									if (repaint) repaint();
								}

								try { Thread.sleep(75); } catch (InterruptedException ie) { }
							}
						}
					};
					dragThread.start();

					repaint();
				}
			}
			if (state == DRAG)
			{
				synchronized (questionsArr)
				{
					mouseX = me.getPoint().x;
					mouseY = me.getPoint().y;

					if (mouseX < 0) mouseX = 0;
					if (mouseX >= WIDTH-16) mouseX = WIDTH-17;
					if (mouseY < 0) mouseY = 0;
					if (mouseY >= HEIGHT) mouseY = HEIGHT-1;

					replacementIndex = -1;

					if (mouseX > 16 || mouseY > 16)
					{
						int curY = SPACE;
						int relative = mouseY+scrollY;

						for (int i = 0; i < questionsArr.size(); i++)
						{
							int height = questionsArr.get(i).computeHeight(WIDTH-16-2*SPACE);
							curY += height/2;

							if (relative <= curY)
							{
								replacementIndex = i;
								break;
							}
							else curY += (height - (height/2)) + SPACE;
						}

						if (replacementIndex == -1) replacementIndex = questionsArr.size();
					}
				}

				repaint();
			}
		}
		public void mouseEntered(MouseEvent me)
		{
			if (state == FROZEN) return;

			mouseMoved(me);
		}
		public void mouseExited(MouseEvent me)
		{
			if (state == FROZEN) return;

			mouseReleased(me);

			state = ABANDONED;
			transientIndex = replacementIndex = scrollFocus = mouseCaptureX = mouseCaptureY = -1;

			repaint();
		}
		public void mouseMoved(MouseEvent me)
		{
			if (state == FROZEN) return;

			mouseReleased(me);

			boolean repaint = false;

			repaint = repaint || (state != NEUTRAL);
			state = NEUTRAL;

			int index = questionIndex(me.getPoint());
			repaint = repaint || (transientIndex != index);
			transientIndex = index;

			int focus = getScrollFocus(me.getPoint());
			repaint = repaint || (scrollFocus != focus);
			scrollFocus = focus;

			if (replacementIndex != -1 || mouseCaptureX != -1 || mouseCaptureY != -1) repaint = true;
			replacementIndex = -1;
			mouseCaptureX = -1;
			mouseCaptureY = -1;

			if (repaint) repaint();
		}
		Thread scrollThread;
		public void mousePressed(MouseEvent me)
		{
			if (state == FROZEN) return;

			mouseMoved(me);

			if (transientIndex != -1)
			{
				if (transientIndex == clickIndex)
				{
					Question quest = null;
					synchronized (questionsArr) { quest = questionsArr.get(transientIndex); }

					long cur = System.currentTimeMillis();
					if (cur-doubleClickRecord <= 400)
					{
						state = FROZEN;
						QEDIT.installForm(quest.replaceForm(transientIndex));
						doubleClickRecord = clickIndex = -1; imminentDrag = false;
						replacementIndex = mouseCaptureX = mouseCaptureY = scrollFocus = -1; return;
					}
				}

				doubleClickRecord = System.currentTimeMillis();
				clickIndex = transientIndex;
				origClick = me.getPoint();
				replacementIndex = mouseCaptureX = mouseCaptureY = scrollFocus = -1;
				imminentDrag = true;	return;
			}

			doubleClickRecord = clickIndex = -1;

			if (scrollFocus != -1)
			{
				if (scrollFocus == 3)
				{
					if (scrollOffAbove(me.getPoint().y))
					{
						scrollY -= HEIGHT;
						if (scrollY < 0) scrollY = 0;
					}
					else
					{
						scrollY += HEIGHT;
						int full = full();
						if (scrollY+HEIGHT > full) scrollY = full-HEIGHT;
					}

					state = SCROLL_PRESS;
					origClick = me.getPoint();
					replacementIndex = mouseCaptureX = mouseCaptureY = -1;
					repaint();

					return;
				}

				state = SCROLL_PRESS;
				origClick = me.getPoint();
				doubleClickRecord = clickIndex = replacementIndex = mouseCaptureX = -1;
				mouseCaptureY = scrollY;
				imminentDrag = false;

				if (scrollFocus != 1)
				{
					scrollThread = new Thread()
					{
						public void run()
						{
							while (true)
							{
								if (scrollFocus == 0)
								{
									scrollY -= 20;
									if (scrollY < 0)
									{
										scrollY = 0;
										return;
									}
								}
								else
								{
									scrollY += 20;
									int full = full();
									if (scrollY > full-HEIGHT)
									{
										scrollY = full-HEIGHT;
										return;
									}
								}

								DragAndDropEditor.this.repaint();
								try { Thread.sleep(75); } catch (InterruptedException ie) { }
							}
						}
					};
					scrollThread.start();
				}

				return;
			}

			replacementIndex = mouseCaptureX = mouseCaptureY = scrollFocus = -1;
			imminentDrag = false;
		}
		public void mouseReleased(MouseEvent me)
		{
			if (state == FROZEN) return;

			if (state == SCROLL_PRESS)
			{
				if (scrollThread != null)
				{
					scrollThread.stop();
					scrollThread = null;
				}
				state = NEUTRAL;
				mouseMoved(me);
				return;
			}
			else if (state == DRAG)
			{
				if (dragThread != null)
				{
					dragThread.stop();
					dragThread = null;
				}

				synchronized (questionsArr)
				{
					if (replacementIndex == -1) questionsArr.remove(transientIndex);
					else if (replacementIndex != transientIndex)
					{
						Question quest = questionsArr.get(transientIndex);

						if (replacementIndex < questionsArr.size()) questionsArr.add(replacementIndex, quest);
						else questionsArr.add(quest);
						if (replacementIndex < transientIndex) questionsArr.remove(transientIndex+1);
						else questionsArr.remove(transientIndex);
					}

					state = NEUTRAL;
					mouseMoved(me);
					repaint();
				}
			}
		}

	}

	/**
	 *	Class: QuestionEditor
	 *
	 *	Second Tabbed panel in the JTabbedPane tabs
	 *	QuestionEditor houses 1 or 0 QuestionForm(s) at a time
	 */
	public class QuestionEditor extends JPanel
	{

		public QuestionForm currentForm = null;

		// Beautiful Hack Redux
		public Dimension getPreferredSize()
		{
			return getSize();
		}

		// Prepares the argument QuestionForm and displays it
		public void installForm(QuestionForm form)
		{
			installForm(form, false);
		}

		// Root method:
		// The suppressInit param should be set to true iff a form is reinstalling itself to accomodate changes to the Component list
		public void installForm(QuestionForm form, boolean suppressInit)
		{
			// Replace form, check Uninstall
			if (currentForm != null && form != null)
			{
				QuestionForm savior = currentForm;
				currentForm = null;
				savior.uninstall();
			}

			// Remove previous Components
			removeAll();
			setLayout(null);

			currentForm = form;
			if (form == null) return;

			// Position components based on a pseudo FlowLayout implementation, the past them
			// Do it Line-by-Line
			int maxX = 0;
			int progY = 5;
			for (ArrayList<Component> list : form.getFields())
			{
				int maxheight = 0;
				for (int i = 0; i < list.size(); i++)
				{
					Component comp = list.get(i);
					comp.setSize(comp.getPreferredSize());

					// Override JTextArea and put it in a JScrollPane
					// JTextArea does not support Scrolling on its own, so this is necessary
					if (comp instanceof JTextArea)
					{
						JScrollPane JSP = new JScrollPane(comp, JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED, JScrollPane.HORIZONTAL_SCROLLBAR_NEVER);
						JTextArea JTA = (JTextArea)comp;
						JTA.setLineWrap(true);
						JTA.setWrapStyleWord(true);
						JSP.setSize(new Dimension(JTA.getSize().width+4, JTA.getSize().height+4));
						comp = JSP;
						list.remove(i);
						if (i == list.size()) list.add(comp); else list.add(i, comp);
					}

					if (maxheight < comp.getHeight()) maxheight = comp.getHeight();
				}
				int progX = 5;
				for (Component comp : list)
				{
					comp.setLocation(progX, progY+maxheight-comp.getHeight());
					progX += 5+comp.getWidth();

					add(comp);
				}
				if (maxX < progX) maxX = progX;
				progY += maxheight+5;
			}

			// Finalize and display
			if (!suppressInit) form.init(this);

			setSize(maxX, progY);
			tabs.setSelectedComponent(QECONTAIN);

			QESCONTAIN.validate();
			QESCONTAIN.repaint();
		}

	}

	// Abstract class for all QuestionForm implementation
	abstract class QuestionForm implements ActionListener
	{

		public QuestionEditor head;

		// Default Submission Listener
		public void actionPerformed(ActionEvent ae)
		{
			submit();
		}

		// Called externally by QuestionEditor
		// Use it to call requestFocus() and stuff - do Component instantiation in constructor
		public void init(QuestionEditor head)
		{
			this.head = head;
			head.repaint();
		}
		public void reinstall()
		{
			head.installForm(this, true);
			head.repaint();
		}

		// Override this if you want
		// This method is called if/when the current form is forcibly replaced by a new one,
		//   without firing the submit() method
		public void uninstall()
		{

		}

		// destroy() and delete() are just so boring
		public void kamikaze()
		{
			head.installForm(null);
		}

		// Return a matrix ArrayList of Components
		// Each "row" is a line of Components, in the form of an array
		public abstract ArrayList<ArrayList<Component>> getFields();

		// Listeners have to be set up for this method
		public abstract void submit();

	}

	// Auxiliary method to save time/space/continuum
	public static <T> ArrayList<T> soloList(T element)
	{
		ArrayList<T> result = new ArrayList<T>();
		result.add(element);
		return result;
	}

	// If input is missing/erroneous, call one of these on it
	// Turns the input field red, and outputs provided error message
	public static void errorify(JTextField component, String txt)
	{
		component.setText(txt);
		component.setBackground(Color.red.brighter());
		component.setForeground(Color.white);
		component.requestFocus();

		final JTextField COMPONENT = component;
		component.addKeyListener(new KeyAdapter()
		{
			public void keyReleased(KeyEvent ke)
			{
				COMPONENT.setBackground(Color.white);
				COMPONENT.setForeground(Color.black);
			}
		});
	}
	public static void errorify(JTextArea component, String txt)
	{
		component.setText(txt);
		component.setBackground(Color.red.brighter());
		component.setForeground(Color.white);
		component.requestFocus();

		final JTextArea COMPONENT = component;
		component.addKeyListener(new KeyAdapter()
		{
			public void keyReleased(KeyEvent ke)
			{
				COMPONENT.setBackground(Color.white);
				COMPONENT.setForeground(Color.black);
			}
		});
	}

	// Fully Abstract Question class
	// Data in here used during ultimateSubmit()
	abstract class Question
	{

		// Construct an "edit" form when this question is double-clicked
		// Parameter index stores the position of the invoking Question in the questionsArr Universal Data
		public abstract QuestionForm replaceForm(int index);

		// Compute the height, preferable using computeRenderHeight
		// Also, recommend use a Dynamic storage variable to save computing time
		// maxWidth variable will not change in subsequent calls
		public abstract int computeHeight(int maxWidth);

		// Render, given the parametric conditions
		// Variables are the same as in renderMultiLine
		// If alpha=true, use a 0.5f AlphaComposite/Color
		public abstract void render(Graphics2D g2d, int x, int y, int maxWidth, boolean alpha, boolean lineRender, Color border);

	}

	public static final int MCINDENT = 20;

	// Utility render method for drawing a Question box, given the multitude of parameters
	// Arrays should all be the same size, and fulfill the same roles as they do in renderMultiLine() way up higher in this document
	public static void renderQuestionBox(Graphics2D g2d, int x, int y, int width, String[] strArr, int[] indentArr, Font[] fontArr,
													 Color[] background, Color[] foreground, Color border, boolean lineRender)
	{
		int yprime = y;
		for (int i = 0; i < strArr.length; i++)
		{
			renderMultiLine(g2d, x, yprime, strArr[i], fontArr[i], width, indentArr[i], background[i], foreground[i]);
			yprime += computeRenderHeight(strArr[i], fontArr[i], width, indentArr[i]);
		}

		g2d.setStroke(new BasicStroke(2));

		if (lineRender)
		{
			g2d.setColor(Color.green);
			g2d.drawLine(x-SPACE/2, y-SPACE/2, x+width+SPACE/2, y-SPACE/2);
		}
		if (border != null)
		{
			g2d.setColor(border);
			g2d.drawRect(x, y, width, yprime-y);
		}
	}

	// Multiple Choice Question Form
	// Nothing really noteworthy of commenting in here
	public class MCQuestionForm extends QuestionForm
	{

		public JLabel qtext = new JLabel("Question Text:");
		public JTextArea actQtext = new JTextArea("Enter Question Text Here", 4, 50);

		public JCheckBox shuffle = new JCheckBox("Shuffle Answers?", true);
		public ArrayList<JCheckBox> boxes = new ArrayList<JCheckBox>();
		public ArrayList<JTextArea> answers = new ArrayList<JTextArea>();

		public JButton moreAnswers = new JButton("More Answers");
		public JButton finish = new JButton("Finish Question/Make New One");
		public JButton cancel = new JButton("Cancel");

		private int firstLabel;

		public final ActionListener extend = new ActionListener()
		{
			public void actionPerformed(ActionEvent ae)
			{
				extend();
			}
		};
		public final ActionListener cancelAct = new ActionListener()
		{
			public void actionPerformed(ActionEvent ae)
			{
				cancel();
			}
		};

		public MCQuestionForm()
		{
			this(0, null, -1);
		}

		public int replaceIndex;
		public MultipleChoice backup;
		public MCQuestionForm(int firstLabel, MultipleChoice source, int replaceIndex)
		{
			this.firstLabel = firstLabel;
			this.replaceIndex = replaceIndex;
			backup = source;

			qtext.setFont(FONT);
			actQtext.setFont(FONT);
			actQtext.addKeyListener(createKeyListener(-1));

			shuffle.setFont(FONT);

			moreAnswers.setFont(FONT);
			moreAnswers.setMargin(new Insets(2,2,2,2));
			finish.setFont(FONT);
			finish.setMargin(new Insets(2,2,2,2));
			cancel.setFont(FONT);
			cancel.setMargin(new Insets(2,2,2,2));

			addAnswers(5);

			finish.addActionListener(this);
			cancel.addActionListener(cancelAct);
			moreAnswers.addActionListener(extend);

			if (replaceIndex != -1)
			{
				finish.setText("Finish Editing Question");

				actQtext.setText(source.qText);
				shuffle.setSelected(source.shuffle);
				for (int i = 0; i < source.choices.size(); i++)
				{
					MCAnswer answer = source.choices.get(i);
					if (i >= 5 && ((i-5)%3) == 0) addAnswers(3);

					boxes.get(i).setSelected(answer.isCorrect);
					answers.get(i).setText(answer.answer);
				}
			}
		}

		public KeyListener createKeyListener(int index)
		{
			final int INDEX = index;

			return new KeyAdapter()
			{
				public void keyReleased(KeyEvent ke)
				{
					if (ke.getKeyCode() == KeyEvent.VK_TAB)
					{
						JTextArea area = ((INDEX == -1) ? actQtext : answers.get(INDEX));
						String text = area.getText(); int index = text.indexOf("\t");
						if (index != -1) area.setText((text.substring(0,index)+text.substring(index+1)).trim());
						else area.setText(text.trim());

						tabFunction();
					}
					else if (ke.getKeyCode() == KeyEvent.VK_ENTER)
					{
						JTextArea area = ((INDEX == -1) ? actQtext : answers.get(INDEX));
						String text = area.getText(); int index = text.indexOf("\n");
						if (index != -1) area.setText((text.substring(0,index)+text.substring(index+1)).trim());
						else area.setText(text.trim());

						if (verify(false)) submit();
						else tabFunction();
					}
				}
				public void tabFunction()
				{
					if (INDEX == boxes.size()-1 || INDEX == -1)
					{
						for (int i = 0; i < boxes.size()-1; i++) if (answers.get(i).getText().trim().equals(""))
						{
							answers.get(i).setText("");
							answers.get(i).requestFocus();
							return;
						}
						extend();
					}
					else answers.get(INDEX+1).requestFocus();
				}
			};
		}

		public void extend()
		{
			addAnswers(3);
			reinstall();
			answers.get(answers.size()-3).requestFocus();
		}
		public void cancel()
		{
			if (replaceIndex == -1)
			{
				kamikaze();
				tabs.setSelectedComponent(DNDCONTAIN);
			}
			else
			{
				unfreezeQuestion(backup, replaceIndex);
			}
		}

		public void init(QuestionEditor head)
		{
			super.init(head);

			actQtext.requestFocus();
		}

		public boolean verify(boolean errorReport)
		{
			actQtext.setText(actQtext.getText().trim());
			if (actQtext.equals("You must enter question text") || actQtext.equals("Enter Question Text Here")) actQtext.setText("");
			if (actQtext.getText().equals(""))
			{
				if (errorReport) errorify(actQtext, "You must enter question text");
				return false;
			}

			int numquestions = 0;
			for (JTextArea field : answers)
			{
				field.setText(field.getText().trim());
				if (field.getText().equals("You must enter at least two choices")) field.setText("");
				if (field.getText().startsWith("You need to choose at least 1 correct answer - "))
					field.setText(field.getText().substring(47));
				if (!field.getText().equals("")) numquestions++;
			}

			if (numquestions < 2)
			{
				if (errorReport)
				{
					if (answers.get(0).getText().equals("")) errorify(answers.get(0), "You must enter at least two choices");
					else errorify(answers.get(1), "You must enter at least two choices");
				}
				return false;
			}

			int numcorrect = 0;
			for (JCheckBox box : boxes) if (box.isSelected()) numcorrect++;

			if (numcorrect == 0)
			{
				if (errorReport) errorify(answers.get(0), "You need to choose at least 1 correct answer - "+answers.get(0).getText());
				return false;
			}

			return true;
		}

		public void submit()
		{
			if (!verify(true)) return;

			ArrayList<MCAnswer> list = new ArrayList<MCAnswer>();

			for (int i = 0; i < boxes.size(); i++) if (!answers.get(i).getText().equals(""))
				list.add(new MCAnswer(answers.get(i).getText(), boxes.get(i).isSelected()));
			MultipleChoice MC = new MultipleChoice(actQtext.getText(), list, shuffle.isSelected());

			if (replaceIndex == -1)
			{
				addQuestion(MC);
				head.installForm(new MCQuestionForm(firstLabel+1, null, -1));
			}
			else unfreezeQuestion(MC, replaceIndex);
		}

		public void uninstall()
		{
			if (replaceIndex != -1) unfreezeQuestion(backup, replaceIndex);
		}

		public void addAnswers(int numAnswers)
		{
			for (int i = 0; i < numAnswers; i++)
			{
				JCheckBox JCB = new JCheckBox("(Correct?) - Answer "+(char)(((int)('a'))+boxes.size())+": ");
				JCB.setSelected(boxes.size() == 0);
				JCB.setFont(FONT);
				boxes.add(JCB);

				JTextArea answer = new JTextArea("", 1, 40);
				answer.setFont(FONT);
				answer.addKeyListener(createKeyListener(boxes.size()-1));
				answers.add(answer);
			}
		}

		public ArrayList<ArrayList<Component>> getFields()
		{
			ArrayList<ArrayList<Component>> fields = new ArrayList<ArrayList<Component>>();

			if (firstLabel != 0)
			{
				JLabel first = new JLabel("Question Submitted Successfully ("+firstLabel+")");
				first.setFont(FONT);
				first.setForeground(Color.green.darker());
				fields.add(soloList((Component)first));
			}

			fields.add(soloList((Component)qtext));
			fields.add(soloList((Component)actQtext));
			fields.add(soloList((Component)shuffle));

			for (int i = 0; i < boxes.size(); i++)
			{
				ArrayList<Component> list = soloList((Component)boxes.get(i));
				list.add(answers.get(i));
				fields.add(list);
			}

			fields.add(soloList((Component)moreAnswers));
			ArrayList<Component> list = soloList((Component)finish);
			list.add(cancel);
			fields.add(list);

			return fields;
		}

	}

	// Multiple Choice Question
	// Specific Question implementations and forms will not have internal comments
	// All the noteworthy stuff is taken care of in the abstract superclasses
	class MultipleChoice extends Question
	{

		public String qText;
		public ArrayList<MCAnswer> choices;
		public boolean shuffle;

		public MultipleChoice()
		{
			this("", new ArrayList<MCAnswer>(), false);
		}
		public MultipleChoice(String qText, ArrayList<MCAnswer> choices, boolean shuffle)
		{
			this.qText = qText;
			this.choices = new ArrayList<MCAnswer>(choices);
			this.shuffle = shuffle;
		}

		int computedHeight = -1;

		public QuestionForm replaceForm(int index)
		{
			return new MCQuestionForm(0, this, index);
		}

		public int computeHeight(int width)
		{
			if (computedHeight == -1)
			{
				int sum = computeRenderHeight(qText, TINY, width, 5);
				for (MCAnswer mc : choices) sum += computeRenderHeight(mc.answer, TINY, width, MCINDENT);
				return (computedHeight = sum);
			}
			else return computedHeight;
		}

		public void render(Graphics2D g2d, int x, int y, int maxWidth, boolean alpha, boolean lineRender, Color border)
		{
			int size = choices.size()+1;

			String[] strArr = new String[size];
			strArr[0] = qText; for (int i = 0; i < size-1; i++) strArr[i+1] = "  "+((char)(((int)'a')+i))+")  "+choices.get(i).answer;
			int[] indentArr = new int[size];
			indentArr[0] = 5; for (int i = 1; i < size; i++) indentArr[i] = MCINDENT;
			Font[] fontArr = new Font[size]; for (int i = 0; i < size; i++) fontArr[i] = TINY;
			Color[] backgroundArr = new Color[size];
			backgroundArr[0] = new Color(0xd0d0d0); for (int i = 1; i < size; i++)
			{
				if ((i%2) == 0)
					if (choices.get(i-1).isCorrect) backgroundArr[i] = new Color(0xd0ffd0);
					else backgroundArr[i] = new Color(0xd0d0d0);
				else
					if (choices.get(i-1).isCorrect) backgroundArr[i] = new Color(0xb0d0b0);
					else backgroundArr[i] = new Color(0xb0b0b0);
			}
			if (alpha) for (int i = 0; i < size; i++) backgroundArr[i] = new Color(((0xffffff & backgroundArr[i].getRGB()) | 0x80000000), true);
			Color[] foregroundArr = new Color[size]; for (int i = 0; i < size; i++) foregroundArr[i] = ((!alpha) ? Color.black : new Color(0x80000000, true));

			renderQuestionBox(g2d, x, y, maxWidth, strArr, indentArr, fontArr, backgroundArr, foregroundArr, border, lineRender);
		}

	}

	// Auxiliary class for MultipleChoice
	public class MCAnswer
	{

		public String answer;
		public boolean isCorrect;

		public MCAnswer()
		{
			this("", false);
		}
		public MCAnswer(String answer, boolean isCorrect)
		{
			this.answer = answer;
			this.isCorrect = isCorrect;
		}

	}

	// Short Answer form
	public class SAQuestionForm extends QuestionForm
	{

		public JLabel qtext = new JLabel("Question Text:");
		public JTextArea actQtext = new JTextArea("Enter Question Text Here", 4, 50);

		public JLabel atext = new JLabel("Exact Answer:");
		public JTextArea actAtext = new JTextArea("", 1, 40);

		public JButton finish = new JButton("Finish Question/Make New One");
		public JButton cancel = new JButton("Cancel");

		public KeyListener keyL = new KeyAdapter()
		{
			public void keyReleased(KeyEvent ke)
			{
				if (ke.getKeyCode() == KeyEvent.VK_TAB || ke.getKeyCode() == KeyEvent.VK_ENTER)
				{
					if (actAtext.getText().trim().equals(""))
					{
						actAtext.setText("");
						actAtext.requestFocus();
					}
					else submit();
				}
			}
		};

		private int firstLabel;

		public final ActionListener cancelAct = new ActionListener()
		{
			public void actionPerformed(ActionEvent ae)
			{
				cancel();
			}
		};

		public SAQuestionForm()
		{
			this(0, null, -1);
		}

		public int replaceIndex;
		public ShortAnswer backup;
		public SAQuestionForm(int firstLabel, ShortAnswer source, int replaceIndex)
		{
			this.firstLabel = firstLabel;
			this.replaceIndex = replaceIndex;
			backup = source;

			qtext.setFont(FONT);
			actQtext.setFont(FONT);
			actQtext.addKeyListener(keyL);
			atext.setFont(FONT);
			actAtext.setFont(FONT);
			actAtext.addKeyListener(keyL);

			finish.setFont(FONT);
			finish.setMargin(new Insets(2,2,2,2));
			cancel.setFont(FONT);
			cancel.setMargin(new Insets(2,2,2,2));

			finish.addActionListener(this);
			cancel.addActionListener(cancelAct);

			if (replaceIndex != -1)
			{
				finish.setText("Finish Editing Question");

				actQtext.setText(source.qText);
				actAtext.setText(source.answer);
			}
		}

		public void cancel()
		{
			if (replaceIndex == -1)
			{
				kamikaze();
				tabs.setSelectedComponent(DNDCONTAIN);
			}
			else
			{
				unfreezeQuestion(backup, replaceIndex);
			}
		}

		public void init(QuestionEditor head)
		{
			super.init(head);

			actQtext.requestFocus();
		}

		public boolean verify(boolean errorReport)
		{
			actQtext.setText(actQtext.getText().trim());
			if (actQtext.equals("You must enter question text") || actQtext.equals("Enter Question Text Here"))
				actQtext.setText("");

			if (actQtext.getText().equals(""))
			{
				if (errorReport) errorify(actQtext, "You must enter question text");
				return false;
			}

			actAtext.setText(actAtext.getText().trim());
			if (actAtext.getText().equals(""))
			{
				if (errorReport) errorify(actAtext, "You must enter an answer");
				return false;
			}

			return true;
		}

		public void submit()
		{
			if (!verify(true)) return;

			ShortAnswer SA = new ShortAnswer(actQtext.getText(), actAtext.getText());

			if (replaceIndex == -1)
			{
				addQuestion(SA);
				head.installForm(new SAQuestionForm(firstLabel+1, null, -1));
			}
			else unfreezeQuestion(SA, replaceIndex);
		}

		public void uninstall()
		{
			if (replaceIndex != -1) unfreezeQuestion(backup, replaceIndex);
		}

		public ArrayList<ArrayList<Component>> getFields()
		{
			ArrayList<ArrayList<Component>> fields = new ArrayList<ArrayList<Component>>();

			if (firstLabel != 0)
			{
				JLabel first = new JLabel("Question Submitted Successfully ("+firstLabel+")");
				first.setFont(FONT);
				first.setForeground(Color.green.darker());
				fields.add(soloList((Component)first));
			}

			fields.add(soloList((Component)qtext));
			fields.add(soloList((Component)actQtext));

			ArrayList<Component> list = soloList((Component)atext); list.add(actAtext); fields.add(list);
			list = soloList((Component)finish); list.add(cancel); fields.add(list);

			return fields;
		}

	}

	// Short Answer Question
	class ShortAnswer extends Question
	{

		String qText, answer;

		public ShortAnswer()
		{
			this("", "");
		}
		public ShortAnswer(String qText, String answer)
		{
			this.qText = qText;
			this.answer = answer;
		}

		public QuestionForm replaceForm(int index)
		{
			return new SAQuestionForm(0, this, index);
		}

		int computedHeight = -1;
		public int computeHeight(int width)
		{
			if (computedHeight == -1)
				computedHeight = computeRenderHeight(qText, TINY, width, 5) + computeRenderHeight("  Answer: "+answer, TINY, width, 20);

			return computedHeight;
		}

		public void render(Graphics2D g2d, int x, int y, int maxWidth, boolean alpha, boolean lineRender, Color border)
		{
			String[] strArr = {qText, "  Answer: "+answer};
			int[] indentArr = {5, 20};
			Font[] fontArr = {TINY, TINY};
			Color[] backgroundArr = new Color[2];
			if (alpha)
			{
				backgroundArr[0] = new Color(0x80c0c0c0, true);
				backgroundArr[1] = new Color(0x80b0d0b0, true);
			}
			else
			{
				backgroundArr[0] = new Color(0xc0c0c0);
				backgroundArr[1] = new Color(0xb0b0b0);
			}
			Color[] foregroundArr = new Color[2];
			if (alpha)
			{
				foregroundArr[0] = new Color(0x80000000, true);
				foregroundArr[1] = new Color(0x80000000, true);
			}
			else
			{
				foregroundArr[0] = Color.black;
				foregroundArr[1] = Color.black;
			}

			renderQuestionBox(g2d, x, y, maxWidth, strArr, indentArr, fontArr, backgroundArr, foregroundArr, border, lineRender);
		}

	}

	// Numerical Answer Form
	public class NUMQuestionForm extends QuestionForm
	{

		public JLabel qtext = new JLabel("Question Text:");
		public JTextArea actQtext = new JTextArea("Enter Question Text Here", 4, 50);

		public JLabel atext = new JLabel("Exact Answer:");
		public JTextArea actAtext = new JTextArea("", 1, 20);
		public JLabel ttext = new JLabel("Tolerance (+):");
		public JTextArea actTtext = new JTextArea("0", 1, 20);

		public JButton finish = new JButton("Finish Question/Make New One");
		public JButton cancel = new JButton("Cancel");

		public KeyListener keyL = new KeyAdapter()
		{
			public void keyReleased(KeyEvent ke)
			{
				if (ke.getKeyCode() == KeyEvent.VK_TAB || ke.getKeyCode() == KeyEvent.VK_ENTER)
				{
					if (actAtext.getText().trim().equals(""))
					{
						actAtext.setText("");
						actAtext.requestFocus();
					}
					else if (ke.getKeyCode() == KeyEvent.VK_TAB && (actTtext.getText().trim().equals("") || actTtext.getText().trim().equals("0")))
					{
						actTtext.setText("0");
						actTtext.requestFocus();
					}
					else submit();
				}
			}
		};

		private int firstLabel;

		public final ActionListener cancelAct = new ActionListener()
		{
			public void actionPerformed(ActionEvent ae)
			{
				cancel();
			}
		};

		public NUMQuestionForm()
		{
			this(0, null, -1);
		}

		public int replaceIndex;
		public Numerical backup;
		public NUMQuestionForm(int firstLabel, Numerical source, int replaceIndex)
		{
			this.firstLabel = firstLabel;
			this.replaceIndex = replaceIndex;
			backup = source;

			qtext.setFont(FONT);
			actQtext.setFont(FONT);
			actQtext.addKeyListener(keyL);

			atext.setFont(FONT);
			actAtext.setFont(FONT);
			actAtext.addKeyListener(keyL);

			ttext.setFont(FONT);
			actTtext.setFont(FONT);
			actTtext.addKeyListener(keyL);

			finish.setFont(FONT);
			finish.setMargin(new Insets(2,2,2,2));
			cancel.setFont(FONT);
			cancel.setMargin(new Insets(2,2,2,2));

			finish.addActionListener(this);
			cancel.addActionListener(cancelAct);

			if (replaceIndex != -1)
			{
				finish.setText("Finish Editing Question");

				actQtext.setText(source.qText);
				actAtext.setText(source.answer+"");
				actTtext.setText(source.linearTolerance+"");
			}
		}

		public void cancel()
		{
			if (replaceIndex == -1)
			{
				kamikaze();
				tabs.setSelectedComponent(DNDCONTAIN);
			}
			else
			{
				unfreezeQuestion(backup, replaceIndex);
			}
		}

		public void init(QuestionEditor head)
		{
			super.init(head);

			actQtext.requestFocus();
		}

		public boolean verify(boolean errorReport)
		{
			actQtext.setText(actQtext.getText().trim());
			if (actQtext.equals("You must enter question text") || actQtext.equals("Enter Question Text Here"))
				actQtext.setText("");
			if (actQtext.getText().equals(""))
			{
				if (errorReport) errorify(actQtext, "You must enter question text");
				return false;
			}

			actAtext.setText(actAtext.getText().trim());
			if (actAtext.getText().equals(""))
			{
				if (errorReport) errorify(actAtext, "You must enter an answer");
				return false;
			}
			try { double val = Double.parseDouble(actAtext.getText()); }
			catch (Exception e) { errorify(actAtext, "Answer must be a valid Decimal number"); return false; }

			actTtext.setText(actTtext.getText().trim());
			if (!actTtext.getText().equals(""))
			{
				try { double val = Double.parseDouble(actTtext.getText()); }
				catch (Exception e) { errorify(actTtext, "Answer must be a valid Decimal number"); return false; }
			}

			return true;
		}

		public void submit()
		{
			if (!verify(true)) return;

			Numerical NUM = new Numerical(actQtext.getText(), Double.parseDouble(actAtext.getText()),
												  ((actTtext.getText().equals("")) ? 0 : Double.parseDouble(actTtext.getText())));

			if (replaceIndex == -1)
			{
				addQuestion(NUM);
				head.installForm(new NUMQuestionForm(firstLabel+1, null, -1));
			}
			else unfreezeQuestion(NUM, replaceIndex);
		}

		public void uninstall()
		{
			if (replaceIndex != -1) unfreezeQuestion(backup, replaceIndex);
		}

		public ArrayList<ArrayList<Component>> getFields()
		{
			ArrayList<ArrayList<Component>> fields = new ArrayList<ArrayList<Component>>();

			if (firstLabel != 0)
			{
				JLabel first = new JLabel("Question Submitted Successfully ("+firstLabel+")");
				first.setFont(FONT);
				first.setForeground(Color.green.darker());
				fields.add(soloList((Component)first));
			}

			fields.add(soloList((Component)qtext));
			fields.add(soloList((Component)actQtext));

			ArrayList<Component> list = soloList((Component)atext); list.add(actAtext); fields.add(list);
			list = soloList((Component)ttext); list.add(actTtext); fields.add(list);
			list = soloList((Component)finish); list.add(cancel); fields.add(list);

			return fields;
		}

	}

	// Numerical Answer Question
	class Numerical extends Question
	{

		String qText;
		double answer, linearTolerance;

		public Numerical()
		{
			this("", 0, 0);
		}
		public Numerical(String qText, double answer, double tolerance)
		{
			this.qText = qText;
			this.answer = answer;
			linearTolerance = tolerance;
		}

		public QuestionForm replaceForm(int index)
		{
			return new NUMQuestionForm(0, this, index);
		}

		int computedHeight = -1;
		public int computeHeight(int width)
		{
			if (computedHeight == -1)
				computedHeight = computeRenderHeight(qText, TINY, width, 10) +
									  computeRenderHeight("  Answer: "+answer+" within +/- "+linearTolerance, TINY, width, 100);

			return computedHeight;
		}

		public void render(Graphics2D g2d, int x, int y, int maxWidth, boolean alpha, boolean lineRender, Color border)
		{
			String[] strArr = {qText, "  Answer: "+answer+" within +/- "+linearTolerance};
			int[] indentArr = {5, 100};
			Font[] fontArr = {TINY, TINY};
			Color[] backgroundArr = new Color[2];
			if (alpha)
			{
				backgroundArr[0] = new Color(0x80c0c0c0, true);
				backgroundArr[1] = new Color(0x80b0d0b0, true);
			}
			else
			{
				backgroundArr[0] = new Color(0xc0c0c0);
				backgroundArr[1] = new Color(0xb0b0b0);
			}
			Color[] foregroundArr = new Color[2];
			if (alpha)
			{
				foregroundArr[0] = new Color(0x80000000, true);
				foregroundArr[1] = new Color(0x80000000, true);
			}
			else
			{
				foregroundArr[0] = Color.black;
				foregroundArr[1] = Color.black;
			}

			renderQuestionBox(g2d, x, y, maxWidth, strArr, indentArr, fontArr, backgroundArr, foregroundArr, border, lineRender);
		}

	}

	// Auxiliary class to the NodeIterator in the htmlparser package
	// Recursively enumerates the Nodes in a Parsed URL
	public class RecursiveIterator
	{

		public Stack<NodeIterator> stack;

		public RecursiveIterator(NodeIterator base) throws ParserException
		{
			stack = new Stack<NodeIterator>();
			if (base.hasMoreNodes()) stack.push(base);
		}

		public boolean hasMoreNodes() throws ParserException
		{
			return (stack.size() != 0);
		}

		public Node nextNode() throws ParserException
		{
			NodeIterator top = stack.pop();

			Node result = top.nextNode();

			NodeList list = result.getChildren();
			NodeIterator children = null;
			if (list != null) children = list.elements();
			if (top.hasMoreNodes()) stack.push(top);
			if (children != null && children.hasMoreNodes()) stack.push(children);

			return result;
		}

	}

}