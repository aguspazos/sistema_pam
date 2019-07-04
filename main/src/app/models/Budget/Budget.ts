import { User, StateChange, CutState, BoundsState } from "..";
import { LaminatedState } from "../LaminatedState/LaminatedState";
import { RumblingState } from "../RumblingState/RumblingState";
import { UvState } from "../UvState/UvState";
import { Client } from "../Client/Client";
import { Delivery } from "../Delivery/Delivery";

export class Budget {
  id?: number;
  print_type_id?: number;
  paper_size?: string;
  paper_type_id?: string;
  prints_amount?: number;
  image_url?: string;
  notes?: string;
  updated_on?: Date;
  due_date?: Date;
  current_work_status_id?: number;
  current_status_type_id?: number;
  token?: string;
  work_prints?: CutState;
  work_laminates?: LaminatedState;
  work_rumblings?: RumblingState;
  work_bounds?: BoundsState;
  stateChanges?: StateChange[];
  work_uvs?: UvState;
  work_delivers?: Delivery;
  client?: Client;
  next_status_name?: string;

  public Budget() {
    this.work_prints = new CutState();
    this.work_laminates = new LaminatedState();
    this.work_rumblings = new RumblingState();
    this.work_bounds = new BoundsState();
    this.work_delivers = new Delivery();
  }
}
