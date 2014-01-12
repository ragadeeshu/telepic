package base;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Set;
import java.util.TreeSet;

public class TPDatabase {
	TreeSet<Integer> keySet;
	private HashMap<Integer, TPPicture> pictures;
	private int min;
	private int max;
	private int current;

	@SuppressWarnings("unchecked")
	public TPDatabase(String fileName) {
		pictures = new HashMap<Integer, TPPicture>();
		try {
			ObjectInputStream in = new ObjectInputStream(new FileInputStream(
					fileName));
			pictures = (HashMap<Integer, TPPicture>) in.readObject();
			in.close();
		} catch (Exception e) {
			System.out.println("No database to load");
		}
		sync();
		try {
			ObjectOutputStream out = new ObjectOutputStream(
					new FileOutputStream(fileName));
			out.writeObject(pictures);
			out.close();
		} catch (Exception e) {
			// e.printStackTrace();
			System.out.println("Could not save database");
		}

	}

	private void sync() {
		ArrayList<Integer> toAdd = new ArrayList<Integer>();
		ArrayList<Integer> ids = null;
		try {
			ids = PhpCaller.getIDs();
		} catch (Exception e) {
			e.printStackTrace();
		}
		Set<Integer> keys = pictures.keySet();
		ArrayList<Integer> toDelete = new ArrayList<Integer>(keys);
		for (int i : ids) {
			toDelete.remove((Integer) i);
			if (!keys.contains(i)) {
				toAdd.add(i);
			}else{
				String[] info = null;
				try {
					info = PhpCaller.getInfo(i);
				} catch (Exception e) {
					e.printStackTrace();
				}	
				pictures.get(i).setInfo(info[PhpCaller.DESCRIPTION]);
			}
		}
		for (int i : toDelete) {
			File fileDelete = new File(pictures.get(i).getPath());
			fileDelete.delete();
			pictures.remove(i);
		}
		for (int i : toAdd) {
			System.out.println("Downlading picture " + i);
			String[] info = null;
			try {
				info = PhpCaller.getInfo(i);
			} catch (Exception e) {
				e.printStackTrace();
			}
			String path = null;
			try {
				path = PhpCaller.downloadImage(info[PhpCaller.SERVERPATH]);
			} catch (Exception e) {
				e.printStackTrace();
			}
			pictures.put(i, new TPPicture(info[PhpCaller.DESCRIPTION], path, info[PhpCaller.DATE], info[PhpCaller.OWNER], i));

		}
		keySet = new TreeSet<Integer>(pictures.keySet());
		min = keySet.first();
		max = keySet.last();
		current = max;
	}

	public TPPicture getPrevious() {
		while (current != min && !keySet.contains(--current))
			;
		return pictures.get(current);
	}

	public TPPicture getNext() {
		while (current != max && !keySet.contains(++current))
			;
		return pictures.get(current);
	}
}
