import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.Collection;
import java.util.HashSet;
import java.util.LinkedList;

// | --- 128 Characters ----------------------------------------------------------------------------------------------------- |

/**
 *	<p>The <code>PreCompile</code> class is used to scan through all the source files of a Project, and prepare the
 *	subcompile.bat file for use.  </p>
 *
 *@author Daniel Ploch
 *@version 1.0 10/31/2008
 */
public class PreCompile
{

	/**
	 *	<p>Variables related to entering of new-line characters.  </p>
	 */
	private static final String NEW_LINE_STRING = "\n\r";

	/**
	 *	<p>Variables related to entering of new-line characters.  </p>
	 */
	private static final byte[] NEW_LINES = NEW_LINE_STRING.getBytes();

	/**
	 *	<p>Keeps track of the number of lines in all the compiled Java Files.  </p>
	 */
	private static long NUM_LINES = 0;

	/**
	 *	<p>Keeps track of the number of comment lines in all the compiled Java Files.  </p>
	 */
	private static long NUM_COMMENTS = 0;

	/**
	 *	<p>Keeps track of the number of bracket lines, containing */ /* { or }.  </p>
	 */
	private static long NUM_BRACKETS = 0;

	/**
	 *	<p>Keeps track of the number of fluff lines, or those that are empty.  </p>
	 */
	private static long NUM_FLUFF = 0;

	/**
	 *	<p>Keeps track of the total number of lines.  </p>
	 */
	private static long TOTAL_LINES = 0;

	/**
	 *	<p>Prepares the subcompile.bat file for use.  </p>
	 *
	 *	<p>Arguments to this class should include exactly one string, specifying the directory of the Java Box Project.</p>
	 */
	public static void main(String[] args)
	{
		if (args.length == 0)
		{
			error();
			return;
		}

		try
		{
			String jarname = args[0];

			File mainFolder = new File("");
			mainFolder = new File(getClassPath(mainFolder.getAbsolutePath()));

			if (!mainFolder.exists())
				throw new NullPointerException("Invalid File Path - " + mainFolder.getAbsolutePath() + " does not exist.");
			if (!mainFolder.isDirectory())
				throw new IllegalArgumentException("Invalid File Path - " + mainFolder.getAbsolutePath() + " is not a directory.");

			LinkedList<File> javaFiles = new LinkedList<File>();
			HashSet<String> packages = new HashSet<String>();
			enumerateJavaFiles(mainFolder, javaFiles);
			for (String str : args) enumeratePackages(mainFolder, str, packages);

			File javaSrc = new File(mainFolder, "javasrc.txt");
			PrintWriter pw = new PrintWriter(new FileOutputStream(javaSrc, false), true);
			for (File file : javaFiles)
				pw.println("\"" + getPath(file.getAbsolutePath()) + "\"");
			pw.close();

			File subCompile = new File(mainFolder, "subcompile.bat");
			pw = new PrintWriter(new FileOutputStream(subCompile, false), true);
			pw.print("\"jdk1.6.0_07/bin/jar.exe\" cvfm " + jarname + ".jar manifest.txt ");
			for (String string : packages)
				pw.print(string + " ");
			pw.println();
			pw.println("\"jdk1.6.0_07/bin/java.exe\" -jar " + jarname + ".jar");
			pw.close();

			System.out.println();
			System.out.println("Java Files: " + javaFiles.size());
			System.out.println("Lines of Code: " + NUM_LINES);
			System.out.println("Lines of Comments: " + NUM_COMMENTS);
			System.out.println("Lines of Brackets: " + NUM_BRACKETS);
			System.out.println("Lines of Spacing: " + NUM_FLUFF);
			System.out.println("Total Lines: " + TOTAL_LINES);
			System.out.println();
			System.out.println("Packages: " + packages.size());
			System.out.println();
			System.out.println("PreCompile complete");
		}
		catch (Exception e)
		{
			e.printStackTrace();
			System.out.println();
			error();
		}
	}

	/**
	 *	<p>Recursively iterates through available files for Java files to be included.  </p>
	 */
	private static void enumerateJavaFiles(File folder, Collection<? super File> javaFiles) throws FileNotFoundException, IOException
	{
		File[] children = folder.listFiles();
		BufferedReader br;

		if (children == null)
		{
			System.out.println("Folder " + folder.getAbsolutePath() + " contains no files.");
			return;
		}

		for (File file : children)
			if (file.isDirectory() && !file.getName().startsWith("jdk"))
				enumerateJavaFiles(file, javaFiles);
			else if (file.getName().endsWith(".java"))
			{
				javaFiles.add(file);
				br = new BufferedReader(new FileReader(file));
				String line;

				while ((line = br.readLine()) != null)
				{
					TOTAL_LINES++;

					line = line.trim();
					if (line.length() == 0 || line.equals("*"))
						NUM_FLUFF++;
					else if (line.equals("/*") || line.equals("//") || line.equals("*/") || line.equals("{") || line.equals("}"))
						NUM_BRACKETS++;
					else if (line.startsWith("//") || line.startsWith("/*") || line.startsWith("*"))
						NUM_COMMENTS++;
					else
						NUM_LINES++;
				}
			}
	}

	/**
	 *	<p>Recursively iterates through specified directory for class files.  </p>
	 */
	private static void enumeratePackages(File folder, String packageName, Collection<? super String> packages)
	{
		File newFolder = new File(folder, packageName);

		subEnumeratePackages(newFolder, packageName, packages);
	}

	/**
	 *	<p>Performs the actual recursive aspect of the <code>enumeratePackages</code> method.  </p>
	 */
	private static void subEnumeratePackages(File folder, String packageName, Collection<? super String> packages)
	{
		File[] files = folder.listFiles();
		boolean foundClass = false;
		boolean foundSer = false;

		if (files == null) return;
		for (File file : files)
			if (file.isDirectory())
				subEnumeratePackages(file, packageName, packages);
			else
			{
				if (!foundClass && file.getName().endsWith(".class"))
					foundClass = true;
				if (!foundSer && file.getName().endsWith(".ser"))
					foundSer = true;
			}

		if (foundClass)
		{
			String path = folder.getAbsolutePath();
			packages.add(getClassPath(folder.getAbsolutePath().substring(path.indexOf(packageName),
							 path.indexOf(folder.getName()) + folder.getName().length())) + "/*.class");
		}
		if (foundSer)
		{
			String path = folder.getAbsolutePath();
			packages.add(getClassPath(folder.getAbsolutePath().substring(path.indexOf(packageName),
							 path.indexOf(folder.getName()) + folder.getName().length())) + "/*.ser");
		}
	}

	/**
	 *	<p>Parses a string file pathname to get it in proper form.  </p>
	 */
	private static String getPath(String pathname)
	{
		String result = pathname;

		for (int i = 0; i < result.length(); i++)
			if (result.charAt(i) == '/' || result.charAt(i) == '\\')
				result = result.substring(0, i) + "\\\\" + result.substring(++i, result.length());

		return result;
	}

	/**
	 *	<p>Parses a string file pathname to get it in proper form.  </p>
	 */
	private static String getClassPath(String pathname)
	{
		String result = pathname;

		for (int i = 0; i < result.length(); i++)
			if (result.charAt(i) == '\\')
				result = result.substring(0, i) + "/" + result.substring(++i, result.length());

		return result;
	}

	/**
	 *	<p>Prints description of the <code>PreCompile</code> program.  </p>
	 */
	private static void error()
	{
		System.out.println("Class: PreCompile\n" +
								 "Usage: java PreCompile packagename\n" +
								 "To be called upon prior to executing subcompile.bat\n" +
								 "subcompile.bat will create the Jar file and execute it");
	}

}